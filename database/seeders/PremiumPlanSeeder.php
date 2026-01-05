<?php

namespace Database\Seeders;

use App\Models\PremiumPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PremiumPlanSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing plans
        PremiumPlan::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create premium plan for Sprint 2
        PremiumPlan::create([
            'name' => 'StudyBuddy Premium',
            'code' => 'PREMIUM_MONTHLY',
            'description' => 'Unlock all premium features including AI recommendations, advanced search, and ad-free experience.',
            'price' => 30.00, // Updated price for students
            'duration_days' => 30,
            'is_active' => true,
            'features' => [
               'Unlimited AI Resource Recommendations',
               'Advanced Search Filters',
               'Ad-Free Experience',
               'Priority Customer Support',
               'Early Access to New Features',
               'Download Study Materials',
               'Collaboration Tools Access'
            ],
            'sort_order' => 1,
        ]);


        // Optional: Create yearly plan (for future)
        PremiumPlan::create([
            'name' => 'StudyBuddy Premium Yearly',
            'code' => 'PREMIUM_YEARLY',
            'description' => 'Get all premium features for a whole year at discounted rate.',
            'price' => 2990.00,
            'duration_days' => 365,
            'is_active' => false, // Not active for Sprint 2
            'features' => [
                'Everything in Monthly Plan',
                'Save 20% compared to monthly',
                'Priority Feature Requests',
                'Dedicated Support Channel'
            ],
            'sort_order' => 2,
        ]);

        $this->command->info('✅ Premium plans seeded successfully!');
    }
}