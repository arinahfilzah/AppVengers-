<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;

class AdminController extends Controller
{
    // Show the main admin dashboard
    public function index()
    {
        // Example: fetch some stats
        $contributorsCount = User::where('role', 'contributor')->count();
        $totalContributions = User::sum('contributions');
        $pendingReviews = Report::where('status', 'pending')->count();
        $approvalRate = User::avg('approval_rate');

        return view('admin.adminpage', compact(
            'contributorsCount',
            'totalContributions',
            'pendingReviews',
            'approvalRate'
        ));
    }

    // Show contributors list
    public function contributors()
    {
        $contributors = User::where('role', 'contributor')->get();
        return view('admin.contributors', compact('contributors'));
    }

    // Show contributor activities
    public function activity()
    {
        // Example: fetch recent activities
        $activities = Report::latest()->take(10)->get();
        return view('admin.activity', compact('activities'));
    }

    // Show analytics
    public function analytics()
    {
        // Example: calculate averages
        $avgApprovalRate = User::avg('approval_rate');
        $avgContentPerWeek = User::avg('weekly_submissions');
        $avgReviewTime = User::avg('review_time');
        $activeContributors = User::where('status', 'Active')->count();
return view('admin.analytics', compact(
            'avgApprovalRate',
            'avgContentPerWeek',
            'avgReviewTime',
            'activeContributors'
        ));
    }

    // Show reports
    public function reports()
    {
        $recentReports = Report::latest()->take(5)->get();
        return view('admin.reports', compact('recentReports'));
    }

    // Show settings
    public function settings()
    {
        return view('admin.settings');
    }
}