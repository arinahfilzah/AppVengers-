<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource;
use App\Models\VerificationRequest;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationApproved;
use App\Mail\VerificationRejected;
use App\Mail\ContentRemoved;
use App\Mail\InfoRequested;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // In the future, fetch real data from database
        $stats = [
            'totalUsers' => 1248,
            'totalContributors' => 89,
            'totalUploads' => 2456,
            'engagementRate' => 76.5,
            'activeUsers' => 342,
            'pendingVerifications' => 12,
            'monthlyUploads' => [65, 59, 80, 81, 56, 55, 40, 70, 85, 92, 77, 88],
            'resourceTypes' => [
                'PDFs' => 59,
                'Videos' => 23,
                'Slides' => 8,
                'Code Files' => 5,
                'Others' => 5
            ]
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    /**
     * Display contributor activities
     */
    public function contributorActivities()
    {
        // Mock data - replace with database queries later
        $contributors = [
            [
                'id' => 1,
                'name' => 'Ali Ahmad',
                'email' => 'aliahmed@graduate.utm.my',
                'status' => 'active',
                'uploads' => 142,
                'downloads' => 2845,
                'rating' => 4.7,
                'lastActivity' => '2 hours ago',
                'specialization' => 'Software Engineering'
            ],
            [
                'id' => 2,
                'name' => 'Siti Sarah',
                'email' => 'sitisarah@graduate.utm.my',
                'status' => 'active',
                'uploads' => 98,
                'downloads' => 1923,
                'rating' => 5.0,
                'lastActivity' => '1 day ago',
                'specialization' => 'Web Programming'
            ],
            [
                'id' => 3,
                'name' => 'Raj Kumar',
                'email' => 'rajkumar@graduate.utm.my',
                'status' => 'pending',
                'uploads' => 23,
                'downloads' => 456,
                'rating' => 5.0,
                'lastActivity' => '3 days ago',
                'specialization' => 'Data Structures'
            ],
            [
                'id' => 4,
                'name' => 'Lisa Tan',
                'email' => 'lisatan@graduate.utm.my',
                'status' => 'inactive',
                'uploads' => 67,
                'downloads' => 1234,
                'rating' => 4.8,
                'lastActivity' => '1 month ago',
                'specialization' => 'Computer Networks'
            ],
            [
                'id' => 5,
                'name' => 'Ahmad Faiz',
                'email' => 'ahmadfaiz@graduate.utm.my',
                'status' => 'active',
                'uploads' => 187,
                'downloads' => 3421,
                'rating' => 4.6,
                'lastActivity' => '5 hours ago',
                'specialization' => 'Security'
            ]
        ];
        
        $summary = [
            'totalContributors' => 89,
            'totalUploads' => 2456,
            'avgPerUser' => 27.6,
            'pending' => 12
        ];
        
        return view('admin.contributor-activities', compact('contributors', 'summary'));
    }
    
    /**
     * Get dashboard statistics via AJAX
     */
    public function getDashboardStats()
    {
        // This will be called via AJAX to update dashboard in real-time
        $stats = [
            'totalUsers' => 1248,
            'totalContributors' => 89,
            'totalUploads' => 2456,
            'engagementRate' => 76.5,
            'activeUsers' => 342,
            'pendingVerifications' => 12,
            'monthlyUploads' => [65, 59, 80, 81, 56, 55, 40, 70, 85, 92, 77, 88],
            'resourceTypes' => [
                'PDFs' => 59,
                'Videos' => 23,
                'Slides' => 8,
                'Code Files' => 5,
                'Others' => 5
            ]
        ];
        
        return response()->json($stats);
    }
    
    /**
     * Get contributor data via AJAX
     */
    public function getContributors(Request $request)
    {
        // This will handle filtering, searching, and pagination via AJAX
        $filters = $request->all();
        
        // In real implementation, query database based on filters
        $contributors = []; // Your database query results
        
        return response()->json([
            'contributors' => $contributors,
            'total' => count($contributors)
        ]);
    }

    // Display all users
    public function viewUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Edit a specific user's role/status
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user role/status
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate input
        $request->validate([
            'role' => 'required|in:admin,user',
            'account_status' => 'required|in:active,suspended',
        ]);

        $user->role = $request->input('role');
        $user->account_status = $request->input('account_status');

        // Save changes
        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User updated successfully');
    }

    // Suspend a user account
    public function suspendUser($id)
    {
        $user = User::findOrFail($id);
        $user->account_status = 'suspended';
        $user->suspended_reason = request('reason');
        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User suspended successfully');
    }

    // Reactivate a user account
    public function reactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->account_status = 'active';
        $user->suspended_reason = null;
        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User reactivated successfully');
    }    
}