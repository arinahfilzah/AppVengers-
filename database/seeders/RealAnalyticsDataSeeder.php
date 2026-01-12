<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Resource;
use App\Models\User;
use App\Models\Download;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RealAnalyticsDataSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Step 1: Sync subjects from existing resources
        $this->syncSubjectsFromResources();
        
        // Step 2: Create sample data jika database kosong
        if (Resource::count() == 0) {
            $this->createSampleResources($admin);
        }
        
        if (Download::count() == 0) {
            $this->createSampleDownloads($admin);
        }
        
        if (Rating::count() == 0) {
            $this->createSampleRatings($admin);
        }

        $this->command->info('✅ Analytics data ready!');
        $this->command->info('📊 Subjects: ' . Subject::count());
        $this->command->info('📚 Resources: ' . Resource::count());
        $this->command->info('⬇️ Downloads: ' . Download::count());
        $this->command->info('⭐ Ratings: ' . Rating::count());
    }
    
    private function syncSubjectsFromResources()
    {
        // Get unique subjects from resources
        $subjects = Resource::whereNotNull('subject')
            ->select('subject')
            ->distinct()
            ->pluck('subject');
        
        foreach ($subjects as $subjectName) {
            if (!empty($subjectName)) {
                Subject::firstOrCreate(
                    ['name' => $subjectName],
                    [
                        'slug' => strtolower(str_replace([' ', '/', '\\'], '-', $subjectName)),
                        'code' => strtoupper(substr($subjectName, 0, 3)) . rand(100, 999),
                        'description' => "Resources for {$subjectName}",
                        'is_active' => true,
                    ]
                );
            }
        }
    }
    
    private function createSampleResources($admin)
    {
        $sampleSubjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'Computer Science'];
        
        foreach ($sampleSubjects as $subject) {
            Subject::firstOrCreate(
                ['name' => $subject],
                [
                    'slug' => strtolower(str_replace(' ', '-', $subject)),
                    'code' => strtoupper(substr($subject, 0, 4)),
                    'description' => "Study materials for {$subject}",
                    'is_active' => true,
                ]
            );
            
            for ($i = 1; $i <= rand(3, 8); $i++) {
                Resource::create([
                    'user_id' => $admin->id,
                    'title' => "{$subject} Resource {$i}",
                    'description' => "Comprehensive guide for {$subject} topic {$i}",
                    'subject' => $subject,
                    'category' => ['Lecture Notes', 'Past Papers', 'Textbook', 'Tutorial'][rand(0, 3)],
                    'year' => rand(1, 4),
                    'file_path' => "uploads/{$subject}/resource-{$i}.pdf",
                    'current_version' => '1.0',
                    'upload_date' => Carbon::now()->subDays(rand(1, 365)),
                ]);
            }
        }
    }
    
    private function createSampleDownloads($admin)
    {
        $resources = Resource::all();
        
        foreach ($resources as $resource) {
            $downloadCount = rand(10, 200);
            
            for ($i = 0; $i < $downloadCount; $i++) {
                Download::create([
                    'resource_id' => $resource->id,
                    'user_id' => $admin->id,
                    'ip_address' => '192.168.' . rand(1, 255) . '.' . rand(1, 255),
                    'user_agent' => $this->getRandomUserAgent(),
                    'created_at' => Carbon::now()->subDays(rand(0, 180)),
                ]);
            }
            
            // Update download count
            if (Schema::hasColumn('resources', 'download_count')) {
                $resource->download_count = $downloadCount;
                $resource->save();
            }
        }
    }
    
    private function createSampleRatings($admin)
    {
        $resources = Resource::all();
        
        foreach ($resources as $resource) {
            $ratingCount = rand(5, 30);
            
            for ($i = 0; $i < $ratingCount; $i++) {
                Rating::create([
                    'resource_id' => $resource->id,
                    'user_id' => $admin->id,
                    'rating' => rand(35, 50) / 10, // 3.5 to 5.0
                    'comment' => ['Helpful!', 'Good resource', 'Very useful'][rand(0, 2)],
                    'created_at' => Carbon::now()->subDays(rand(0, 180)),
                ]);
            }
            
            // Calculate average rating
            $avgRating = Rating::where('resource_id', $resource->id)->avg('rating') ?? 0;
            
            // Update resource if columns exist
            if (Schema::hasColumn('resources', 'rating_count')) {
                $resource->rating_count = $ratingCount;
            }
            if (Schema::hasColumn('resources', 'average_rating')) {
                $resource->average_rating = round($avgRating, 2);
            }
            $resource->save();
        }
    }
    
    private function getRandomUserAgent()
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15',
        ];
        return $agents[array_rand($agents)];
    }
}