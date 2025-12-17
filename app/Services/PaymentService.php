<?php

namespace App\Services;

use App\Models\User;
use App\Models\PremiumPlan;
use App\Models\MockPayment;
use Illuminate\Support\Str;

class PaymentService
{
    // Process mock payment
    public function processMockPayment(User $user, PremiumPlan $plan, array $paymentData)
    {
        // Generate transaction ID
        $transactionId = 'MOCK-' . strtoupper(uniqid()) . '-' . date('Ymd');
        
        // Determine payment status based on test card
        $status = $this->determinePaymentStatus($paymentData['card_number']);
        
        // Create payment record
        $payment = MockPayment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'transaction_id' => $transactionId,
            'amount' => 0.00, // Mock payment
            'currency' => 'LKR',
            'status' => $status,
            'payment_method' => 'credit_card',
            'card_last_four' => substr($paymentData['card_number'], -4),
            'card_brand' => $this->getCardBrand($paymentData['card_number']),
            'payment_details' => [
                'card_number' => $paymentData['card_number'],
                'expiry_month' => $paymentData['expiry_month'],
                'expiry_year' => $paymentData['expiry_year'],
                'cvc' => $paymentData['cvc'],
                'cardholder_name' => $paymentData['cardholder_name'],
            ],
            'processed_at' => now(),
        ]);

        // If payment successful, upgrade user
        if ($status === 'success') {
            $user->account_type = 'premium';
            $user->premium_expires_at = now()->addDays($plan->duration_days);
            $user->save();
        }

        return $payment;
    }

    // Determine if payment succeeds or fails based on test card
    private function determinePaymentStatus($cardNumber)
    {
        $successCards = ['4242424242424242', '5555555555554444'];
        $failureCards = ['4000000000000002'];
        
        if (in_array($cardNumber, $successCards)) {
            return 'success';
        } elseif (in_array($cardNumber, $failureCards)) {
            return 'failed';
        }
        
        // Default: accept any valid 16-digit number as success for testing
        return (strlen($cardNumber) === 16 && is_numeric($cardNumber)) 
            ? 'success' 
            : 'failed';
    }

    // Get card brand for display
    private function getCardBrand($cardNumber)
    {
        if (Str::startsWith($cardNumber, '4')) {
            return 'visa';
        } elseif (Str::startsWith($cardNumber, '5')) {
            return 'mastercard';
        }
        return 'unknown';
    }

    // Validate payment form data
    public function validatePaymentData(array $data)
    {
        $errors = [];

        // Card number validation
        if (empty($data['card_number']) || strlen($data['card_number']) !== 16 || !is_numeric($data['card_number'])) {
            $errors['card_number'] = 'Please enter a valid 16-digit card number';
        }

        // Expiry validation
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        if (empty($data['expiry_year']) || $data['expiry_year'] < $currentYear) {
            $errors['expiry_year'] = 'Expiry year must be in the future';
        } elseif ($data['expiry_year'] == $currentYear && $data['expiry_month'] < $currentMonth) {
            $errors['expiry_month'] = 'Expiry month must be in the future';
        }

        // CVC validation
        if (empty($data['cvc']) || strlen($data['cvc']) !== 3 || !is_numeric($data['cvc'])) {
            $errors['cvc'] = 'Please enter a valid 3-digit CVC';
        }

        // Cardholder name validation
        if (empty($data['cardholder_name']) || strlen(trim($data['cardholder_name'])) < 2) {
            $errors['cardholder_name'] = 'Please enter cardholder name';
        }

        return $errors;
    }
}