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
| Authentication
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
    | Resource Management
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
    |--------------------------------------------x------------------------------
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
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/adminpage', [AdminController::class, 'index'])->name('adminpage');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/contributors', [AdminController::class, 'contributors'])->name('contributors');
    Route::get('/admin/activity', [AdminController::class, 'activity'])->name('activity');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('settings');
});
