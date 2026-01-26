<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PremiumAdminController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AnalyticsController;

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
| Public QR Access (No Login)
|--------------------------------------------------------------------------
*/
Route::get('/r/{token}', [ResourceController::class, 'viewByQrCode'])->name('resource.view');

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

    // QR Code Routes
    Route::get('/resource/{id}/generate-qr', [ResourceController::class, 'generateQrCode'])->name('resource.generateQr');
    Route::get('/resource/{id}/download-qr', [ResourceController::class, 'downloadQrCode'])->name('resource.downloadQr');

    // Download
    Route::get('/resource/{id}/download', [ResourceController::class, 'downloadResource'])->name('resource.download');

    // Version Control Routes (ALL IN ONE PLACE - NO DUPLICATES)
    Route::get('/resource/{id}/versions', [ResourceController::class, 'showVersionHistory'])->name('resource.versionHistory');
    Route::get('/resource/{resource}/version/{version}/download', [ResourceController::class, 'downloadVersion'])->name('resource.downloadVersion');
    Route::get('/resource/{resource}/version/{version}/view', [ResourceController::class, 'viewVersion'])->name('resource.viewVersion');
    Route::post('/resource/{resource}/version/{version}/restore', [ResourceController::class, 'restoreVersion'])->name('resource.restoreVersion');
    
    // Update version
    Route::get('/resource/{id}/update-version', [ResourceController::class, 'showUpdateVersionForm'])->name('resource.updateVersionForm');
    Route::post('/resource/{id}/new-version', [ResourceController::class, 'storeNewVersion'])->name('resource.storeNewVersion');

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

    /*
    |--------------------------------------------------------------------------
    | Premium Routes (User)
    |--------------------------------------------------------------------------
    */
    Route::get('/premium', [PremiumController::class, 'plans'])->name('premium.plans');
    Route::get('/premium/checkout/{plan}', [PremiumController::class, 'checkout'])->name('premium.checkout');
    Route::get('/premium/success', [PremiumController::class, 'success'])->name('premium.success');
    Route::post('/premium/process', [PaymentController::class, 'process'])->name('premium.process');

    /*
    |--------------------------------------------------------------------------
    | Collaboration Routes
    |--------------------------------------------------------------------------
    */
    Route::post('/collaboration/request/{resource}', [CollaborationController::class, 'requestCollaboration'])->name('collaboration.request');
    Route::get('/collaboration/requests', [CollaborationController::class, 'viewRequests'])->name('collaboration.requests');
    Route::post('/collaboration/approve/{request}', [CollaborationController::class, 'approveRequest'])->name('collaboration.approve');
    Route::post('/collaboration/reject/{request}', [CollaborationController::class, 'rejectRequest'])->name('collaboration.reject');
    Route::get('/collaboration/my-requests', [CollaborationController::class, 'myRequests'])->name('collaboration.myRequests');

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */
    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Contributor Activities
        Route::get('/contributors', [AdminController::class, 'contributorActivities'])->name('contributor-activities');
        Route::get('/stats/dashboard', [AdminController::class, 'getDashboardStats'])->name('stats.dashboard');
        Route::get('/stats/contributors', [AdminController::class, 'getContributors'])->name('stats.contributors');

        // Verification
        Route::get('/verification', function () {
            return view('admin.verification');
        })->name('verification');
        Route::post('/verification/{id}/approve', [AdminController::class, 'approveVerification'])->name('verification.approve');
        Route::post('/verification/{id}/reject', [AdminController::class, 'rejectVerification'])->name('verification.reject');
        Route::post('/verification/{id}/request-info', [AdminController::class, 'requestInfoVerification'])->name('verification.requestInfo');

        // Reviews (Content Review)
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::get('/reviews/{id}/preview', [AdminController::class, 'previewContent'])->name('reviews.preview');
        Route::post('/resources/{id}/approve', [AdminController::class, 'approveContent'])->name('resources.approve');
        Route::post('/reviews/{id}/remove', [AdminController::class, 'removeContent'])->name('reviews.remove');

        // User Management
        Route::get('/users', [AdminController::class, 'viewUsers'])->name('viewUsers');
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('showUser');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
        Route::put('/users/{id}/update', [AdminController::class, 'updateUser'])->name('updateUser');
        Route::post('/users/{id}/suspend', [AdminController::class, 'suspendUser'])->name('suspendUser');
        Route::post('/users/{id}/reactivate', [AdminController::class, 'reactivateUser'])->name('reactivateUser');

        // Analytics - Subject Reports
        Route::get('/analytics/subjectreport', [AdminController::class, 'subjectReportPage'])->name('analytics.subjectreport');
        Route::get('/analytics/subjectreport/data', [AdminController::class, 'subjectReportData'])->name('analytics.subjectreport.data');
        Route::get('/analytics/subjectreport/export', [AdminController::class, 'exportSubjectReport'])->name('analytics.subjectreport.export');

        // Analytics - Performance
        Route::get('/analytics/performance', [AdminController::class, 'performancePage'])->name('analytics.performance');
        Route::get('/analytics/performance/data', [AdminController::class, 'performanceData'])->name('analytics.performance.data');
        Route::get('/analytics/performance/export', [AdminController::class, 'exportPerformanceReport'])->name('analytics.performance.export');

        // Analytics - Legacy
        Route::post('/analytics/generate', [AnalyticsController::class, 'generateReport'])->name('analytics.generate');
        Route::get('/analytics/export/pdf', [AnalyticsController::class, 'exportPDF'])->name('analytics.export.pdf');
        Route::get('/analytics/export/excel', [AnalyticsController::class, 'exportExcel'])->name('analytics.export.excel');

        // Premium Management
        Route::prefix('premium')->name('premium.')->group(function () {
            // Dashboard
            Route::get('/management', [PremiumAdminController::class, 'management'])->name('management');
            
            // Plans CRUD
            Route::get('/plans', [PremiumAdminController::class, 'plans'])->name('plans');
            Route::post('/plans/add', [PremiumAdminController::class, 'addPlan'])->name('add-plan');
            Route::put('/plans/{id}/update', [PremiumAdminController::class, 'updatePlan'])->name('update-plan');
            Route::delete('/plans/{id}/delete', [PremiumAdminController::class, 'deletePlan'])->name('delete-plan');
            Route::post('/plans/{id}/toggle-status', [PremiumAdminController::class, 'togglePlanStatus'])->name('toggle-plan-status');
            
            // Transactions
            Route::get('/transactions', [PremiumAdminController::class, 'transactions'])->name('transactions');
            Route::get('/transactions/{id}', [PremiumAdminController::class, 'viewTransaction'])->name('transaction');
            Route::post('/transactions/{id}/refund', [PremiumAdminController::class, 'refundTransaction'])->name('refund-transaction');
            
            // Subscriptions
            Route::get('/subscriptions', [PremiumAdminController::class, 'subscriptions'])->name('subscriptions');
            Route::get('/subscriptions/plan/{planId}', [PremiumAdminController::class, 'planSubscriptions'])->name('subscriptions.plan');
            Route::post('/subscriptions/{userId}/extend', [PremiumAdminController::class, 'extendSubscription'])->name('extend-subscription');
            Route::post('/subscriptions/{userId}/cancel', [PremiumAdminController::class, 'cancelSubscription'])->name('cancel-subscription');
            Route::post('/subscriptions/{userId}/manual-add', [PremiumAdminController::class, 'manualAddSubscription'])->name('manual-add-subscription');
            
            // Analytics
            Route::get('/analytics', [PremiumAdminController::class, 'analytics'])->name('analytics');
            Route::get('/revenue-report', [PremiumAdminController::class, 'revenueReport'])->name('revenue-report');
            
            // Settings
            Route::get('/settings', [PremiumAdminController::class, 'settings'])->name('settings');
            Route::post('/settings/update', [PremiumAdminController::class, 'updateSettings'])->name('update-settings');
        });
    });