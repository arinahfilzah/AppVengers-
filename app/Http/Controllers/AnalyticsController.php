<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function generateReport(Request $request)
    {
        // Hardcoded data sahaja
        $data = [
            'success' => true,
            'data' => [
                'stats' => [
                    'total_downloads' => 2300,
                    'total_subjects' => 8,
                    'avg_rating' => 4.2,
                    'active_users' => 120
                ],
                'chart' => [
                    'labels' => ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'Computer Science', 'English', 'History', 'Geography'],
                    'data' => [450, 380, 320, 280, 420, 210, 180, 150]
                ],
                'subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Mathematics',
                        'resources' => 15,
                        'downloads' => 450,
                        'rating' => '4.5',
                        'growth' => '12.5',
                        'trend' => 'up'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Computer Science',
                        'resources' => 12,
                        'downloads' => 420,
                        'rating' => '4.7',
                        'growth' => '25.3',
                        'trend' => 'up'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Physics',
                        'resources' => 10,
                        'downloads' => 380,
                        'rating' => '4.2',
                        'growth' => '8.3',
                        'trend' => 'up'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Chemistry',
                        'resources' => 8,
                        'downloads' => 320,
                        'rating' => '4.0',
                        'growth' => '5.2',
                        'trend' => 'up'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Biology',
                        'resources' => 7,
                        'downloads' => 280,
                        'rating' => '3.8',
                        'growth' => '-2.1',
                        'trend' => 'down'
                    ],
                    [
                        'id' => 6,
                        'name' => 'English',
                        'resources' => 6,
                        'downloads' => 210,
                        'rating' => '4.1',
                        'growth' => '3.5',
                        'trend' => 'stable'
                    ],
                    [
                        'id' => 7,
                        'name' => 'History',
                        'resources' => 5,
                        'downloads' => 180,
                        'rating' => '3.9',
                        'growth' => '-5.2',
                        'trend' => 'down'
                    ],
                    [
                        'id' => 8,
                        'name' => 'Geography',
                        'resources' => 4,
                        'downloads' => 150,
                        'rating' => '3.7',
                        'growth' => '1.8',
                        'trend' => 'stable'
                    ]
                ],
                'insights' => [
                    [
                        'type' => 'success',
                        'message' => 'Mathematics is the most popular subject with 450 downloads'
                    ],
                    [
                        'type' => 'success',
                        'message' => 'Computer Science shows highest growth at 25.3%'
                    ],
                    [
                        'type' => 'info',
                        'message' => 'Total of 2300 downloads across all subjects'
                    ],
                    [
                        'type' => 'warning',
                        'message' => 'History shows a decline of -5.2% in downloads'
                    ]
                ]
            ]
        ];
        
        return response()->json($data);
    }
    
    public function exportPDF(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'PDF export would be implemented here'
        ]);
    }
    
    public function exportExcel(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Excel export would be implemented here'
        ]);
    }
}