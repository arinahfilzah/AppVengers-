<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
    Route::get('/account', [AuthController::class, 'showUserProfile'])->name('account');

    Route::post('/account/update-profile', [AuthController::class, 'updateProfile'])->name('account.update-profile');
    Route::post('/account/update-password', [AuthController::class, 'updatePassword'])->name('account.update-password');
    Route::post('/account/security-preferences', [AuthController::class, 'updateSecurityPreferences'])->name('account.update-security');
    Route::get('/account/login-history-data', [AuthController::class, 'loginHistoryData'])->name('account.login-history-data');
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');

    /*
    |--------------------------------------------------------------------------
    | Resource Management Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/upload-resource', [ResourceController::class, 'showUploadForm'])->name('uploadResource');
    Route::post('/upload-resource', [ResourceController::class, 'store'])->name('uploadResource.store');
    Route::get('/manage-resource', [ResourceController::class, 'manageResource'])->name('manageResource');
    Route::get('/resource/{id}/edit', [ResourceController::class, 'edit'])->name('resource.edit');
    Route::put('/resource/{id}', [ResourceController::class, 'update'])->name('resource.update');
    Route::delete('/resource/{id}', [ResourceController::class, 'destroy'])->name('resource.destroy');
    Route::get('/resource/{id}/generate-qr', [ResourceController::class, 'generateQrCode'])->name('resource.generateQr');
    Route::get('/resource/{id}/download-qr', [ResourceController::class, 'downloadQrCode'])->name('resource.downloadQr');
    Route::get('/resource/{id}/download', [ResourceController::class, 'downloadResource'])->name('resource.download');

    /*
    |--------------------------------------------------------------------------
    | Course Browsing
    |--------------------------------------------------------------------------
    */
    Route::get('/course', [ResourceController::class, 'browseSubjects'])->name('course');
    Route::get('/course/{subject}', [ResourceController::class, 'browseSubjectResources'])->name('subject.resources');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
    Route::get('/search', [ResourceController::class, 'search'])->name('resource.search');
});

/*
|--------------------------------------------------------------------------
| Public QR Access (No Login)
|--------------------------------------------------------------------------
*/
Route::get('/r/{token}', [ResourceController::class, 'viewByQrCode'])->name('resource.view');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin']) // ✅ add auth too
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Contributor Activities
    Route::get('/contributors', [AdminController::class, 'contributorActivities'])->name('contributor-activities');
    Route::get('/stats/dashboard', [AdminController::class, 'getDashboardStats'])->name('stats.dashboard');
    Route::get('/stats/contributors', [AdminController::class, 'getContributors'])->name('stats.contributors');

    // Verification Routes
    Route::get('/verification', function () {
        return view('admin.verification');
    })->name('verification');
    Route::post('/verification/{id}/approve', [AdminController::class, 'approveVerification']);
    Route::post('/verification/{id}/reject', [AdminController::class, 'rejectVerification']);
    Route::post('/verification/{id}/request-info', [AdminController::class, 'requestInfoVerification']);

    // Review Routes
    Route::get('/reviews', function () {
        return view('admin.reviews');
    })->name('reviews');
    Route::post('/reviews/{id}/approve', [AdminController::class, 'approveContent']);
    Route::post('/reviews/{id}/remove', [AdminController::class, 'removeContent']);

        // User Management
        Route::get('/users', [AdminController::class, 'viewUsers'])->name('viewUsers');

        // ✅ NEW: View user details (UC01 Step 3)
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('showUser');

        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
        Route::put('/users/{id}/update', [AdminController::class, 'updateUser'])->name('updateUser');

        // ✅ Suspend requires reason now
        Route::post('/users/{id}/suspend', [AdminController::class, 'suspendUser'])->name('suspendUser');
        Route::post('/users/{id}/reactivate', [AdminController::class, 'reactivateUser'])->name('reactivateUser');
    });

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Subject Reports (UC08)
    Route::get('/analytics/subjectreport', function () {
        return view('admin.analytics.subjectreport');
    })->name('analytics.subjectreport');
    
    // Resource Analytics (UC09)
    Route::get('/analytics/performance', function () {
        return view('admin.analytics.performance');
    })->name('analytics.performance');
    
    // AJAX Endpoints
    Route::post('/analytics/generate', [AnalyticsController::class, 'generateReport'])->name('analytics.generate');
    Route::get('/analytics/performance/data', [AnalyticsController::class, 'getPerformanceData'])->name('analytics.performance.data');
    Route::get('/analytics/export/pdf', [AnalyticsController::class, 'exportPDF'])->name('analytics.export.pdf');
    Route::get('/analytics/export/excel', [AnalyticsController::class, 'exportExcel'])->name('analytics.export.excel');
});
