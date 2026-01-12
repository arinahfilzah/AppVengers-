<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Resource;
use App\Models\VerificationRequest;
use App\Models\AdminNotification;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationApproved;
use App\Mail\VerificationRejected;
use App\Mail\ContentRemoved;
use App\Mail\InfoRequested;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
{
    // 1) Total users
    $totalUsers = User::count();

    // 2) Total uploads
    $totalUploads = Resource::count();

    // 3) Contributors = users who uploaded at least 1 resource
    $totalContributors = User::where('role', 'user')
    ->whereIn('id', function ($q) {
        $q->select('uploader_id')->from('resources');
    })
    ->count();

    // 4) Active users (24h) based on last_login
    $activeUsers = User::whereNotNull('last_login')
        ->where('last_login', '>=', now()->subDay())
        ->count();

    // 5) Pending verifications (only if your table exists + has status)
    // If you don't have status column, tell me and I’ll adjust.
    $pendingVerifications = \Schema::hasTable('verification_requests')
        ? VerificationRequest::where('status', 'pending')->count()
        : 0;

    // 6) Monthly uploads (last 12 months)
    $start = now()->subMonths(11)->startOfMonth();
    $monthlyRaw = Resource::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
        ->where('created_at', '>=', $start)
        ->groupBy('ym')
        ->orderBy('ym')
        ->pluck('total', 'ym');

    $monthlyUploads = [];
    for ($i = 0; $i < 12; $i++) {
        $ym = $start->copy()->addMonths($i)->format('Y-m');
        $monthlyUploads[] = (int) ($monthlyRaw[$ym] ?? 0);
    }

    // 7) Resource types (use category)
    $resourceTypes = Resource::selectRaw('category, COUNT(*) as total')
        ->groupBy('category')
        ->orderByDesc('total')
        ->pluck('total', 'category')
        ->toArray();

    // 8) Top contributor activities (for dashboard table)
    // NOTE: resources.uploader_id is string in your migration, but in DB it's id-style.
    // This join works as long as uploader_id stores user IDs like "26".
    $topContributors = User::query()
        ->select('users.id', 'users.name', 'users.email', 'users.account_status')
        ->where('users.role', 'user')
        ->join('resources', 'resources.uploader_id', '=', 'users.id')
        ->selectRaw('COUNT(resources.id) as upload_count')
        ->selectRaw('MAX(resources.created_at) as last_activity_at')
        ->groupBy('users.id', 'users.name', 'users.email', 'users.account_status')
        ->orderByDesc('upload_count')
        ->limit(5)
        ->get();

    $stats = [
        'totalUsers' => $totalUsers,
        'totalContributors' => $totalContributors,
        'totalUploads' => $totalUploads,
        'activeUsers' => $activeUsers,
        'pendingVerifications' => $pendingVerifications,
        'monthlyUploads' => $monthlyUploads,
        'resourceTypes' => $resourceTypes,
        'topContributors' => $topContributors,
    ];

    return view('admin.dashboard', compact('stats'));
}
    
    /**
     * Display contributor activities
     */
    public function contributorActivities(Request $request)
{
    $status = $request->query('status');   // active|suspended|null
    $sort   = $request->query('sort');     // upload_desc|upload_asc|recent
    $q      = $request->query('q');        // search name/email

    $contributorsQuery = User::query()
        ->select('users.id', 'users.name', 'users.email', 'users.account_status', 'users.last_login')
        ->join('resources', 'resources.uploader_id', '=', 'users.id')
        ->selectRaw('COUNT(resources.id) as uploads')
        ->selectRaw('MAX(resources.created_at) as last_upload_at')
        ->groupBy('users.id', 'users.name', 'users.email', 'users.account_status', 'users.last_login');

    // Filter status (only active/suspended)
    if (in_array($status, ['active', 'suspended'])) {
        $contributorsQuery->where('users.account_status', $status);
    }

    // Search name/email
    if (!empty($q)) {
        $contributorsQuery->where(function($sub) use ($q) {
            $sub->where('users.name', 'like', "%{$q}%")
                ->orWhere('users.email', 'like', "%{$q}%");
        });
    }

    // Sort
    if ($sort === 'upload_asc') {
        $contributorsQuery->orderBy('uploads', 'asc');
    } elseif ($sort === 'recent') {
        $contributorsQuery->orderByDesc('last_upload_at');
    } else {
        $contributorsQuery->orderByDesc('uploads'); // default
    }

    $contributors = $contributorsQuery->paginate(10)->withQueryString();

    // Summary cards
    $totalContributors = (clone $contributorsQuery)->get()->count(); // contributors filtered by join
    $totalUploads = Resource::count();
    $avgPerUser = $totalContributors > 0 ? round($totalUploads / $totalContributors, 1) : 0;

    // Pending Review (resources)
    // ✅ If you have a column like review_status in resources table:
    $pendingReview = \Schema::hasColumn('resources', 'review_status')
        ? Resource::where('review_status', 'pending')->count()
        : 0;

    $summary = [
        'totalContributors' => $totalContributors,
        'totalUploads' => $totalUploads,
        'avgPerUser' => $avgPerUser,
        'pendingReview' => $pendingReview,
    ];

    return view('admin.contributor-activities', compact('contributors', 'summary', 'status', 'sort', 'q'));
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

    // ✅ UC01 Step 1+2: View list + Search
    public function viewUsers(Request $request)
    {
        $search = $request->query('search');

        $users = User::query()
            ->when($search, function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.users.index', compact('users', 'search'));
    }

    // ✅ UC01 Step 3: View user details
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,user',
            'account_status' => 'required|in:active,suspended',
        ]);

        $user->role = $request->role;
        $user->account_status = $request->account_status;

        // If admin manually sets suspended from edit page, allow optional reason
        if ($request->account_status === 'suspended') {
            $user->suspended_reason = $request->input('suspended_reason');
        } else {
            $user->suspended_reason = null;
        }

        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User updated successfully');
    }

    // ✅ UC02 Step 2–3: Suspend user with reason
    public function suspendUser(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->account_status = 'suspended';
        $user->suspended_reason = $request->reason;
        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User suspended successfully');
    }

    // ✅ UC02 Step 5: Reactivate user
    public function reactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->account_status = 'active';
        $user->suspended_reason = null;
        $user->save();

        return redirect()->route('admin.viewUsers')->with('success', 'User reactivated successfully');
    }

public function reviews(Request $request)
{
    // filter: pending|approved|rejected
    $filter = $request->query('filter', 'pending');
    $search = $request->query('q');

    // If you created review_status column in resources, use it.
    // statuses: pending | approved | rejected
    $query = Resource::query()
        ->with('uploader')
        ->when(\Schema::hasColumn('resources', 'review_status'), function ($q) use ($filter) {
            if (in_array($filter, ['pending', 'approved', 'rejected'])) {
                $q->where('review_status', $filter);
            }
        })
        ->when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%");
        })
        ->orderByDesc('created_at');

    $resources = $query->paginate(9)->withQueryString();

    // Count badges
    $counts = [
        'pending'  => \Schema::hasColumn('resources', 'review_status') ? Resource::where('review_status', 'pending')->count() : 0,
        'approved' => \Schema::hasColumn('resources', 'review_status') ? Resource::where('review_status', 'approved')->count() : 0,
        'rejected' => \Schema::hasColumn('resources', 'review_status') ? Resource::where('review_status', 'rejected')->count() : 0,
    ];

    return view('admin.reviews', compact('resources', 'counts', 'filter', 'search'));
}

// Approve = set review_status=approved
public function approveContent($id)
{
    $resource = Resource::findOrFail($id);

    if (!\Schema::hasColumn('resources', 'review_status')) {
        return response()->json(['message' => 'review_status column not found.'], 422);
    }

    $resource->review_status = 'approved';
    $resource->save();

    return response()->json(['message' => 'Approved']);
}

// Remove = set review_status=rejected and optionally store reason
public function removeContent(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|string|max:50',
        'notes'  => 'required|string|max:1000',
        'notify' => 'nullable|boolean',
    ]);

    $resource = Resource::with('uploader')->findOrFail($id);

    if (!\Schema::hasColumn('resources', 'review_status')) {
        return response()->json(['message' => 'review_status column not found.'], 422);
    }

    $resource->review_status = 'rejected';

    // Optional: if you created columns for reason/notes, save them
    if (\Schema::hasColumn('resources', 'rejection_reason')) {
        $resource->rejection_reason = $request->reason;
    }
    if (\Schema::hasColumn('resources', 'rejection_notes')) {
        $resource->rejection_notes = $request->notes;
    }

    $resource->save();

    // Optional notify uploader by email (only if you want)
    // if ($request->boolean('notify') && $resource->uploader && $resource->uploader->email) {
    //     Mail::to($resource->uploader->email)->send(new ContentRemoved($resource, $request->reason, $request->notes));
    // }

    return response()->json(['message' => 'Removed']);
}

public function previewContent($id)
{
    $resource = Resource::with('uploader')->findOrFail($id);

    // File extension
    $ext = strtolower(pathinfo($resource->file_path ?? '', PATHINFO_EXTENSION));

    // Build a preview URL
    // If file_path is stored like "resources/xxx.pdf" in storage/app/public,
    // Storage::url() will generate /storage/resources/xxx.pdf (requires storage:link).
    $previewUrl = null;

    if (!empty($resource->file_path)) {
        // If file_path already contains "storage/..." or "http", just return it.
        if (str_starts_with($resource->file_path, 'http')) {
            $previewUrl = $resource->file_path;
        } else {
            // Assume it's inside public disk
            $previewUrl = Storage::disk('public')->url($resource->file_path);
        }
    }

    return response()->json([
        'id' => $resource->id,
        'title' => $resource->title,
        'description' => $resource->description,
        'category' => $resource->category,
        'year' => $resource->year,
        'subject' => $resource->subject,
        'status' => $resource->review_status ?? 'pending',
        'uploaded_at' => optional($resource->created_at)->toDateTimeString(),
        'uploaded_human' => optional($resource->created_at)->diffForHumans(),
        'uploader' => [
            'name' => optional($resource->uploader)->name ?? 'Unknown',
            'email' => optional($resource->uploader)->email ?? '',
        ],
        'file' => [
            'path' => $resource->file_path,
            'ext' => $ext,
            'preview_url' => $previewUrl,
        ]
    ]);
}

public function performancePage(Request $request)
{
    // dynamic subject dropdown from DB
    $subjects = Resource::query()
        ->select('subject')
        ->whereNotNull('subject')
        ->where('subject', '!=', '')
        ->distinct()
        ->orderBy('subject')
        ->pluck('subject');

    return view('admin.analytics.performance', compact('subjects'));
}

public function performanceData(Request $request)
{
    $days = (int) $request->query('days', 30);
    if (!in_array($days, [7, 30, 90])) $days = 30;

    $subject = $request->query('subject', 'all');
    $since = now()->subDays($days);

    // Detect columns (so code doesn't crash)
    $hasDownloads = Schema::hasColumn('resources', 'download_count');
    $hasViews     = Schema::hasColumn('resources', 'view_count');

    // Base query (only approved resources is common for analytics)
    $q = Resource::query()
        ->with('uploader:id,name')
        ->where('created_at', '>=', $since);

    // If you want analytics only for approved content, uncomment:
    // if (Schema::hasColumn('resources', 'review_status')) {
    //     $q->where('review_status', 'approved');
    // }

    if ($subject !== 'all') {
        $q->where('subject', $subject);
    }

    // Build list
    $resources = $q->orderByDesc($hasDownloads ? 'download_count' : 'created_at')
        ->limit(200)
        ->get()
        ->map(function ($r) use ($hasDownloads, $hasViews) {

            $downloads = $hasDownloads ? (int) ($r->download_count ?? 0) : 0;
            $views     = $hasViews ? (int) ($r->view_count ?? 0) : 0;

            // Performance label based on downloads
            $performance =
                $downloads >= 100 ? 'excellent' :
                ($downloads >= 30 ? 'good' :
                ($downloads >= 10 ? 'average' : 'low'));

            return [
                'id' => $r->id,
                'title' => $r->title,
                'subject' => $r->subject ?? 'N/A',
                'category' => $r->category ?? 'N/A',
                'upload_date' => optional($r->created_at)->format('Y-m-d'),
                'uploader' => optional($r->uploader)->name ?? 'Unknown',
                'downloads' => $downloads,
                'views' => $views,
                'performance' => $performance,
            ];
        })
        ->values();

    // Metrics
    $totalResources = $resources->count();
    $totalDownloads = $resources->sum('downloads');
    $totalViews     = $resources->sum('views');

    $lowPerforming = $resources->where('performance', 'low')->count();
    $topPerformers = $resources->whereIn('performance', ['excellent', 'good'])->count();

    $topList = $resources->sortByDesc('downloads')->take(5)->values();
    $needsImprovement = $resources->sortBy('downloads')->take(5)->values();

    return response()->json([
        'success' => true,
        'generated_at' => now()->format('d M Y, h:i A'),
        'metrics' => [
            'total_downloads' => $totalDownloads,
            'total_resources' => $totalResources,
            'total_views' => $totalViews,
            'low_performing' => $lowPerforming,
            'top_performers' => $topPerformers,
        ],
        'resources' => $resources,
        'topPerformers' => $topList,
        'needsImprovement' => $needsImprovement,
    ]);
}

public function exportPerformanceReport(Request $request): StreamedResponse
{
    $days = (int) $request->query('days', 30);
    if (!in_array($days, [7, 30, 90])) $days = 30;

    $subject = $request->query('subject', 'all');
    $since = now()->subDays($days);

    $hasDownloads = Schema::hasColumn('resources', 'download_count');
    $hasViews     = Schema::hasColumn('resources', 'view_count');

    $q = Resource::query()
        ->with('uploader:id,name')
        ->where('created_at', '>=', $since);

    if ($subject !== 'all') {
        $q->where('subject', $subject);
    }

    $filename = "performance_report_{$days}days_" . now()->format('Ymd_His') . ".csv";

    return response()->streamDownload(function () use ($q, $hasDownloads, $hasViews) {
        $out = fopen('php://output', 'w');

        fputcsv($out, ['ID', 'Title', 'Subject', 'Uploader', 'Uploaded At', 'Downloads', 'Views', 'Category']);

        $q->orderByDesc($hasDownloads ? 'download_count' : 'created_at')
            ->chunk(500, function ($rows) use ($out, $hasDownloads, $hasViews) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->id,
                        $r->title,
                        $r->subject,
                        optional($r->uploader)->name,
                        optional($r->created_at)->format('Y-m-d H:i:s'),
                        $hasDownloads ? (int) ($r->download_count ?? 0) : 0,
                        $hasViews ? (int) ($r->view_count ?? 0) : 0,
                        $r->category,
                    ]);
                }
            });

        fclose($out);
    }, $filename, [
        'Content-Type' => 'text/csv',
    ]);
}
public function subjectReportPage()
{
    // Year dropdown values from DB (resources.year)
    $years = Resource::query()
        ->select('year')
        ->whereNotNull('year')
        ->distinct()
        ->orderBy('year')
        ->pluck('year');

    return view('admin.analytics.subjectreport', compact('years'));
}

public function subjectReportData(Request $request)
{
    // Inputs
    $start = $request->query('start'); // yyyy-mm-dd
    $end   = $request->query('end');   // yyyy-mm-dd
    $year  = $request->query('year', 'all'); // all | 1 | 2 | 3 | 4

    // Default range = last 30 days
    $startDate = $start ? Carbon::parse($start)->startOfDay() : now()->subDays(30)->startOfDay();
    $endDate   = $end ? Carbon::parse($end)->endOfDay() : now()->endOfDay();

    // For trend comparison: previous period same length
    $days = $startDate->diffInDays($endDate) + 1;
    $prevStart = (clone $startDate)->subDays($days);
    $prevEnd   = (clone $endDate)->subDays($days);

    // Do we have download/view columns?
    $hasDownloads = Schema::hasColumn('resources', 'download_count'); // if you have it
    $hasViews     = Schema::hasColumn('resources', 'view_count');     // if you have it

    // Base query (current period)
    $base = Resource::query()
        ->whereBetween('created_at', [$startDate, $endDate])
        ->whereNotNull('subject')
        ->where('subject', '!=', '');

    if ($year !== 'all' && $year !== null && $year !== '') {
        $base->where('year', $year);
    }

    // Group by subject for current period
    $subjects = (clone $base)
        ->selectRaw('subject, COUNT(*) as resources_count')
        ->when($hasDownloads, fn($q) => $q->addSelect(\DB::raw('SUM(download_count) as downloads_sum')))
        ->when($hasViews, fn($q) => $q->addSelect(\DB::raw('SUM(view_count) as views_sum')))
        ->groupBy('subject')
        ->orderByDesc($hasDownloads ? 'downloads_sum' : 'resources_count')
        ->get();

    // Previous period query for trend
    $prev = Resource::query()
        ->whereBetween('created_at', [$prevStart, $prevEnd])
        ->whereNotNull('subject')
        ->where('subject', '!=', '');

    if ($year !== 'all' && $year !== null && $year !== '') {
        $prev->where('year', $year);
    }

    $prevMap = (clone $prev)
        ->selectRaw('subject, COUNT(*) as resources_count')
        ->when($hasDownloads, fn($q) => $q->addSelect(\DB::raw('SUM(download_count) as downloads_sum')))
        ->groupBy('subject')
        ->get()
        ->keyBy('subject');

    // Build table rows
    $rows = $subjects->map(function ($s) use ($prevMap, $hasDownloads) {
        $currentMetric = $hasDownloads ? (int)($s->downloads_sum ?? 0) : (int)($s->resources_count ?? 0);

        $prevRow = $prevMap->get($s->subject);
        $prevMetric = 0;
        if ($prevRow) {
            $prevMetric = $hasDownloads ? (int)($prevRow->downloads_sum ?? 0) : (int)($prevRow->resources_count ?? 0);
        }

        $trend = '→';
        if ($currentMetric > $prevMetric) $trend = '↑';
        if ($currentMetric < $prevMetric) $trend = '↓';

        return [
            'subject'   => $s->subject,
            'downloads' => $hasDownloads ? (int)($s->downloads_sum ?? 0) : 0,
            'views'     => $hasViews ? (int)($s->views_sum ?? 0) : 0,
            'resources' => (int)($s->resources_count ?? 0),
            'trend'     => $trend,
        ];
    })->values();

    // Metrics (cards)
    $totalDownloads = $rows->sum('downloads');
    $totalSubjects  = $rows->count();

    // Active users (use users.last_login if you have it)
    $activeUsers = Schema::hasColumn('users', 'last_login')
        ? User::whereNotNull('last_login')->where('last_login', '>=', now()->subDays(7))->count()
        : 0;

    // Chart: Top 8 subjects
    $top = $rows->sortByDesc($hasDownloads ? 'downloads' : 'resources')->take(8)->values();

    // Insights (simple)
    $insights = [];
    if ($top->count() > 0) {
        $insights[] = ($top[0]['subject'] ?? 'N/A') . ' is currently the top subject.';
    }
    $down = $rows->where('trend', '↓')->count();
    if ($down > 0) $insights[] = "{$down} subjects show a downward trend vs previous period.";
    if ($totalSubjects === 0) $insights[] = 'No data for selected filters. Try expanding the date range.';

    return response()->json([
        'success' => true,
        'generated_at' => now()->format('d M Y, h:i A'),
        'stats' => [
            'downloads' => $totalDownloads,
            'subjects'  => $totalSubjects,
            'users'     => $activeUsers,
        ],
        'chart' => [
            'labels' => $top->pluck('subject')->values(),
            'data'   => $top->pluck($hasDownloads ? 'downloads' : 'resources')->values(),
            'mode'   => $hasDownloads ? 'downloads' : 'resources',
        ],
        'rows' => $rows,
        'insights' => $insights,
    ]);
}

public function exportSubjectReport(Request $request): StreamedResponse
{
    $start = $request->query('start');
    $end   = $request->query('end');
    $year  = $request->query('year', 'all');

    $startDate = $start ? Carbon::parse($start)->startOfDay() : now()->subDays(30)->startOfDay();
    $endDate   = $end ? Carbon::parse($end)->endOfDay() : now()->endOfDay();

    $hasDownloads = Schema::hasColumn('resources', 'download_count');
    $hasViews     = Schema::hasColumn('resources', 'view_count');

    $q = Resource::query()
        ->whereBetween('created_at', [$startDate, $endDate])
        ->whereNotNull('subject')
        ->where('subject', '!=', '');

    if ($year !== 'all' && $year !== null && $year !== '') {
        $q->where('year', $year);
    }

    $grouped = $q->selectRaw('subject, COUNT(*) as resources_count')
        ->when($hasDownloads, fn($qq) => $qq->addSelect(\DB::raw('SUM(download_count) as downloads_sum')))
        ->when($hasViews, fn($qq) => $qq->addSelect(\DB::raw('SUM(view_count) as views_sum')))
        ->groupBy('subject')
        ->orderByDesc($hasDownloads ? 'downloads_sum' : 'resources_count');

    $filename = "subject_report_" . now()->format('Ymd_His') . ".csv";

    return response()->streamDownload(function () use ($grouped, $hasDownloads, $hasViews) {
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Subject', 'Resources', 'Downloads', 'Views']);

        $grouped->chunk(200, function ($rows) use ($out, $hasDownloads, $hasViews) {
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->subject,
                    (int)($r->resources_count ?? 0),
                    $hasDownloads ? (int)($r->downloads_sum ?? 0) : 0,
                    $hasViews ? (int)($r->views_sum ?? 0) : 0,
                ]);
            }
        });

        fclose($out);
    }, $filename, ['Content-Type' => 'text/csv']);
}
}