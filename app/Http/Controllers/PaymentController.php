<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\PremiumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $premiumService;

    public function __construct(PaymentService $paymentService, PremiumService $premiumService)
    {
        $this->paymentService = $paymentService;
        $this->premiumService = $premiumService;
    }

    // Process payment form submission
    public function process(Request $request)
    {
        $user = Auth::user();
        
        // Get selected plan from session
        $planId = session('selected_plan_id');
        if (!$planId) {
            return redirect()->route('premium.plans')
                ->with('error', 'Please select a plan first.');
        }

        // Load selected plan
        $plan = $this->premiumService->getPlan($planId);

        // Validate payment data
        $validationErrors = $this->paymentService->validatePaymentData($request->all());
        if (!empty($validationErrors)) {
            return back()->withErrors($validationErrors)->withInput();
        }

        // Process payment
        $payment = $this->paymentService->processMockPayment(
            $user, 
            $plan, 
            $request->only(['card_number', 'expiry_month', 'expiry_year', 'cvc', 'cardholder_name'])
        );

        // Clear session
        session()->forget('selected_plan_id');

        // Redirect based on result
        if ($payment->status === 'success') {
            return redirect()->route('premium.success')
                ->with('success', 'Payment successful! Your account has been upgraded to premium.');
        } else {
            return redirect()->route('premium.checkout', $plan->id)
                ->with('error', 'Payment failed. Please try again with a different card.');
        }
    }
}