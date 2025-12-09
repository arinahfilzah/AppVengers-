<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AdminController;

// -------------------
// Landing Page
// -------------------
Route::get('/', function () {
    return view('home');
})->name('home');

// -------------------
// Dashboard & Other Pages (Require Login)
// -------------------
Route::get('/dashboard', [AuthController::class, 'showDashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/userProfile', function () {
    return redirect()->route('account');
})->middleware('auth');

Route::get('/account', [AuthController::class, 'showUserProfile'])
    ->middleware('auth')
    ->name('account');


// -------------------
// Resource Management Routes (Authenticated)
// -------------------
Route::middleware('auth')->group(function () {
    // Upload Resource
    Route::get('/upload-resource', [ResourceController::class, 'showUploadForm'])
        ->name('uploadResource');
    
    Route::post('/upload-resource', [ResourceController::class, 'store'])
        ->name('uploadResource.store');

    // Manage Resources
    Route::get('/manage-resource', [ResourceController::class, 'manageResource'])
        ->name('manageResource');

    // Edit Resource
    Route::get('/resource/{id}/edit', [ResourceController::class, 'edit'])
        ->name('resource.edit');

    // Update Resource
    Route::put('/resource/{id}', [ResourceController::class, 'update'])
        ->name('resource.update');

    // Delete Resource
    Route::delete('/resource/{id}', [ResourceController::class, 'destroy'])
        ->name('resource.destroy');

    // Generate QR Code (GET route for clicking link)
    Route::get('/resource/{id}/generate-qr', [ResourceController::class, 'generateQrCode'])
        ->name('resource.generateQr');

    // Download QR Code
    Route::get('/resource/{id}/download-qr', [ResourceController::class, 'downloadQrCode'])
        ->name('resource.downloadQr');

    // Download Resource File
    Route::get('/resource/{id}/download', [ResourceController::class, 'downloadResource'])
        ->name('resource.download');

    

    // -------------------
// Course Page with Subjects
// -------------------

Route::middleware('auth')->group(function () {

    // Browse all subjects
    Route::get('/course', [ResourceController::class, 'browseSubjects'])
        ->name('course');

    // Browse resources under selected subject
    Route::get('/course/{subject}', [ResourceController::class, 'browseSubjectResources'])
        ->name('subject.resources');
});



});

// -------------------
// Public QR Code Access (No Auth Required)
// -------------------
Route::get('/r/{token}', [ResourceController::class, 'viewByQrCode'])
    ->name('resource.view');

// -------------------
// Authentication Routes
// -------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])
    ->middleware('auth')
    ->name('account.delete');

Route::post('/account/update-password', [AuthController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('account.update-password');

// -------------------
// Admin Routes
// -------------------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/adminpage', [AdminController::class, 'index'])->name('adminpage');
    Route::get('/admin/contributors', [AdminController::class, 'contributors'])->name('contributors');
    Route::get('/admin/activity', [AdminController::class, 'activity'])->name('activity');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('settings');
});