<?php

namespace App\Services;

use App\Models\PremiumPlan;
use App\Models\User;

class PremiumService
{
    // Get all active premium plans
    public function getActivePlans()
    {
        return PremiumPlan::where('is_active', true)->orderBy('sort_order')->get();
    }

    // Get plan by ID
    public function getPlan($planId)
    {
        return PremiumPlan::where('is_active', true)->findOrFail($planId);
    }

    // Check if user can purchase premium
    public function canPurchasePremium(User $user)
    {
        // User must be basic or premium expired
        return $user->account_type === 'basic' || 
               ($user->account_type === 'premium' && 
                (!$user->premium_expires_at || $user->premium_expires_at < now()));
    }

    // Get user's premium status info
    public function getUserPremiumInfo(User $user)
    {
        return [
            'is_premium' => $user->account_type === 'premium' && 
                           $user->premium_expires_at && 
                           $user->premium_expires_at > now(),
            'account_type' => $user->account_type,
            'expires_at' => $user->premium_expires_at,
            'can_upgrade' => $this->canPurchasePremium($user),
        ];
    }
}