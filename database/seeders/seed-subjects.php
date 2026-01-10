<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Seeding subjects table...\n";

// Clear existing data
DB::table('subjects')->truncate();

$subjects = [
    ['name' => 'Mathematics', 'year_level' => 'Year 1', 'downloads' => 450, 'resources' => 25, 'rating' => 4.5, 'trend' => 'up', 'growth' => 15.5],
    ['name' => 'Physics', 'year_level' => 'Year 2', 'downloads' => 380, 'resources' => 18, 'rating' => 4.2, 'trend' => 'up', 'growth' => 8.3],
    ['name' => 'Chemistry', 'year_level' => 'Year 2', 'downloads' => 320, 'resources' => 22, 'rating' => 4.0, 'trend' => 'stable', 'growth' => 0.5],
    ['name' => 'Biology', 'year_level' => 'Year 1', 'downloads' => 290, 'resources' => 19, 'rating' => 4.3, 'trend' => 'down', 'growth' => -3.2],
    ['name' => 'Computer Science', 'year_level' => 'Year 3', 'downloads' => 260, 'resources' => 15, 'rating' => 4.8, 'trend' => 'up', 'growth' => 22.1],
    ['name' => 'History', 'year_level' => 'Year 1', 'downloads' => 210, 'resources' => 12, 'rating' => 3.9, 'trend' => 'stable', 'growth' => 1.2],
    ['name' => 'Literature', 'year_level' => 'Year 2', 'downloads' => 190, 'resources' => 14, 'rating' => 4.1, 'trend' => 'up', 'growth' => 5.7],
    ['name' => 'Economics', 'year_level' => 'Year 4', 'downloads' => 175, 'resources' => 10, 'rating' => 3.8, 'trend' => 'down', 'growth' => -2.4],
    ['name' => 'Psychology', 'year_level' => 'Year 3', 'downloads' => 155, 'resources' => 11, 'rating' => 4.4, 'trend' => 'up', 'growth' => 12.8],
    ['name' => 'Statistics', 'year_level' => 'Year 4', 'downloads' => 120, 'resources' => 8, 'rating' => 3.7, 'trend' => 'stable', 'growth' => 0.8],
];

foreach ($subjects as $subject) {
    $subject['created_at'] = now();
    $subject['updated_at'] = now();
    DB::table('subjects')->insert($subject);
}

echo "Seeded " . count($subjects) . " subjects successfully!\n";