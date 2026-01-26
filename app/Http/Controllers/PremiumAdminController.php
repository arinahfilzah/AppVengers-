<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PremiumPlan;
use App\Models\PremiumTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PremiumAdminController extends Controller
{
    public function management()
    {
        $plans = PremiumPlan::withCount(['activeSubscriptions as active_subscriptions_count'])
            ->latest()
            ->get();
    
        $recentTransactions = PremiumTransaction::with(['user', 'plan'])
            ->latest()
            ->limit(10)
            ->get();
            
        $premiumUsers = User::where('is_premium', true)
            ->where('premium_expiry', '>', now())
            ->with(['activeSubscription'])
            ->limit(12)
            ->get();
            
        $stats = [
            'totalPremiumUsers' => User::where('is_premium', true)
                ->where('premium_expiry', '>', now())
                ->count(),
            'totalRevenue' => PremiumTransaction::where('status', 'success')->sum('amount'),
            'todayTransactions' => PremiumTransaction::whereDate('created_at', today())->count(),
            'plansCount' => $plans->count(),
        ];
    
        return view('admin.premium.management', compact('plans', 'recentTransactions', 'premiumUsers', 'stats'));
    }
    
    public function addPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $plan = PremiumPlan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'features' => $request->features ? $this->formatFeatures($request->features) : [],
            'is_active' => $request->has('is_active'),
        ]);
        
        return back()->with('success', 'Premium plan added successfully!');
    }
    
    public function updatePlan(Request $request, $id)
    {
        $plan = PremiumPlan::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'features' => $request->features ? $this->formatFeatures($request->features) : $plan->features,
            'is_active' => $request->has('is_active'),
        ]);
        
        return back()->with('success', 'Plan updated successfully!');
    }
    
    public function deletePlan($id)
    {
        $plan = PremiumPlan::findOrFail($id);
        
        // Check if plan has active subscriptions
        if ($plan->activeSubscriptions()->exists()) {
            return back()->with('error', 'Cannot delete plan with active subscriptions!');
        }
        
        $plan->delete();
        return back()->with('success', 'Plan deleted successfully!');
    }
    
    public function togglePlanStatus($id)
    {
        $plan = PremiumPlan::findOrFail($id);
        $plan->is_active = !$plan->is_active;
        $plan->save();
        
        return response()->json(['success' => true, 'is_active' => $plan->is_active]);
    }
    
    public function transactions()
    {
        $transactions = PremiumTransaction::with(['user', 'plan'])
            ->latest()
            ->paginate(20);
            
        $stats = [
            'total' => PremiumTransaction::count(),
            'successful' => PremiumTransaction::where('status', 'success')->count(),
            'failed' => PremiumTransaction::where('status', 'failed')->count(),
            'totalRevenue' => PremiumTransaction::where('status', 'success')->sum('amount'),
        ];
        
        return view('admin.premium.transactions', compact('transactions', 'stats'));
    }
    
    public function viewTransaction($id)
    {
        $transaction = PremiumTransaction::with(['user', 'plan'])->findOrFail($id);
        return view('admin.premium.transaction-detail', compact('transaction'));
    }
    
    public function refundTransaction(Request $request, $id)
    {
        $transaction = PremiumTransaction::with('user')->findOrFail($id);
        
        if ($transaction->status !== 'success') {
            return back()->with('error', 'Only successful transactions can be refunded!');
        }
        
        DB::transaction(function () use ($transaction, $request) {
            // Refund to user's wallet
            $transaction->user->increment('wallet_balance', $transaction->amount);
            
            // Update transaction status
            $transaction->update([
                'status' => 'refunded',
                'refunded_at' => now(),
                'refund_reason' => $request->reason,
            ]);
            
            // Cancel user's premium if this was their last transaction
            $activeTransactions = PremiumTransaction::where('user_id', $transaction->user_id)
                ->where('status', 'success')
                ->where('id', '!=', $transaction->id)
                ->exists();
                
            if (!$activeTransactions) {
                $transaction->user->update([
                    'is_premium' => false,
                    'premium_expiry' => null,
                ]);
            }
        });
        
        return back()->with('success', 'Transaction refunded successfully!');
    }
    
    public function subscriptions()
    {
        $subscriptions = User::where('is_premium', true)
            ->where('premium_expiry', '>', now())
            ->with(['activeSubscription.plan'])
            ->latest('premium_expiry')
            ->paginate(20);
            
        return view('admin.premium.subscriptions', compact('subscriptions'));
    }
    
    public function extendSubscription(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
            'note' => 'nullable|string|max:255',
        ]);
        
        $currentExpiry = $user->premium_expiry ? Carbon::parse($user->premium_expiry) : now();
        $newExpiry = $currentExpiry->addDays($request->days);
        
        $user->update([
            'premium_expiry' => $newExpiry,
        ]);
        
        // Log admin action
        PremiumTransaction::create([
            'user_id' => $user->id,
            'plan_id' => null,
            'amount' => 0,
            'balance_before' => $user->wallet_balance,
            'balance_after' => $user->wallet_balance,
            'transaction_id' => 'ADMIN-' . time(),
            'payment_method' => 'admin_manual',
            'status' => 'success',
            'notes' => 'Admin extension: ' . $request->note,
        ]);
        
        return back()->with('success', "Subscription extended for {$request->days} days!");
    }
    
    public function cancelSubscription(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $request->validate([
            'reason' => 'required|string|max:255',
            'refund_amount' => 'nullable|numeric|min:0',
        ]);
        
        DB::transaction(function () use ($user, $request) {
            // Refund if specified
            if ($request->refund_amount > 0) {
                $user->increment('wallet_balance', $request->refund_amount);
            }
            
            // Cancel premium
            $user->update([
                'is_premium' => false,
                'premium_expiry' => null,
            ]);
            
            // Log cancellation
            PremiumTransaction::create([
                'user_id' => $user->id,
                'plan_id' => null,
                'amount' => -$request->refund_amount,
                'balance_before' => $user->wallet_balance,
                'balance_after' => $user->wallet_balance,
                'transaction_id' => 'CANCEL-' . time(),
                'payment_method' => 'admin_cancellation',
                'status' => 'cancelled',
                'notes' => 'Admin cancellation: ' . $request->reason,
            ]);
        });
        
        return back()->with('success', 'Subscription cancelled successfully!');
    }
    
    public function analytics()
    {
        // Daily revenue for last 30 days
        $revenueData = PremiumTransaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as revenue'),
            DB::raw('COUNT(*) as transactions')
        )
        ->where('status', 'success')
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Plan popularity
        $planPopularity = PremiumPlan::withCount(['transactions as purchase_count' => function($query) {
            $query->where('status', 'success');
        }])->get();
        
        // User growth
        $userGrowth = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_users'),
            DB::raw('SUM(CASE WHEN is_premium = 1 THEN 1 ELSE 0 END) as premium_users')
        )
        ->where('created_at', '>=', now()->subDays(90))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        return view('admin.premium.analytics', compact('revenueData', 'planPopularity', 'userGrowth'));
    }
    
    public function revenueReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        $report = PremiumTransaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'success')
            ->with(['user', 'plan'])
            ->get();
            
        $summary = [
            'total_revenue' => $report->sum('amount'),
            'total_transactions' => $report->count(),
            'average_transaction' => $report->avg('amount'),
            'unique_users' => $report->unique('user_id')->count(),
        ];
        
        return view('admin.premium.revenue-report', compact('report', 'summary', 'startDate', 'endDate'));
    }
    
    public function settings()
    {
        $settings = [
            'premium_enabled' => config('premium.enabled', true),
            'auto_renewal' => config('premium.auto_renewal', false),
            'default_plan_id' => config('premium.default_plan_id'),
            'free_trial_days' => config('premium.free_trial_days', 0),
            'currency' => config('premium.currency', 'RM'),
        ];
        
        return view('admin.premium.settings', compact('settings'));
    }
    
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'premium_enabled' => 'boolean',
            'auto_renewal' => 'boolean',
            'default_plan_id' => 'nullable|exists:premium_plans,id',
            'free_trial_days' => 'integer|min:0|max:30',
            'currency' => 'string|size:3',
        ]);
        
        // Update config file or database settings
        // This depends on how you store settings
        
        return back()->with('success', 'Settings updated successfully!');
    }
    
    private function formatFeatures($features)
    {
        if (is_string($features)) {
            $features = explode("\n", $features);
            $features = array_map('trim', $features);
            $features = array_filter($features);
        }
        
        return $features;
    }
}