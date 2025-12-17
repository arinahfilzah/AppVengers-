<?php

namespace App\Http\Controllers;

use App\Services\PremiumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    protected $premiumService;

    public function __construct(PremiumService $premiumService)
    {
        $this->premiumService = $premiumService;
    }

    // Show premium plans page
    public function plans()
    {
        // Check if user can purchase premium
        $user = Auth::user();
        if (!$this->premiumService->canPurchasePremium($user)) {
            return redirect()->route('dashboard')
                ->with('info', 'You already have an active premium subscription.');
        }

        $plans = $this->premiumService->getActivePlans();
        
        return view('premium.plans', [
            'plans' => $plans,
            'user' => $user,
        ]);
    }

    // Show checkout page for selected plan
    public function checkout($planId)
    {
        $user = Auth::user();
        $plan = $this->premiumService->getPlan($planId);

        // Store plan in session for payment processing
        session(['selected_plan' => $plan]);

        return view('premium.checkout', [
            'plan' => $plan,
            'user' => $user,
        ]);
    }

    // Show payment success page
    public function success()
    {
        return view('premium.success');
    }
}