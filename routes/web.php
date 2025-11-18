<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AdminController;

// -------------------
// Landing Page
// -------------------
Route::get('/', function () {
    return view('home');  // Landing page
})->name('home');

// -------------------
// Dashboard & Other Pages (Require Login)
// -------------------
Route::get('/dashboard', [AuthController::class, 'showDashboard'])
    ->middleware('auth')
    ->name('dashboard');


// User Profile (Settings & Info)
Route::get('/userProfile', function () {
    return redirect()->route('account');
})->middleware('auth');

// Account Page (can reuse userProfile for now)
Route::get('/account', [AuthController::class, 'showUserProfile'])
    ->middleware('auth')
    ->name('account');

// Other pages
Route::get('/upload-resource', function () {
    return view('resource.uploadResource');
})->middleware('auth')->name('uploadResource');

Route::get('/course', function () {
    return view('course');
})->middleware('auth')->name('course');

Route::post('/upload-resource', [ResourceController::class, 'store'])
    ->name('uploadResource.store');

Route::get('/manage-resource', [ResourceController::class, 'manageResource'])
    ->name('manageResource');

Route::get('/resource/{id}/edit', [ResourceController::class, 'edit'])
    ->name('resource.edit');

Route::put('/resource/{id}', [ResourceController::class, 'update'])
    ->name('resource.update');

Route::get('/upload-resource', [ResourceController::class, 'showUploadForm'])
    ->name('uploadResource');

Route::delete('/resource/{id}', [ResourceController::class, 'destroy'])
    ->name('resource.destroy');




// -------------------
// Authentication Routes
// -------------------

// Show Forms
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

// Handle Form Submissions
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('password.email');

// Show Reset Password Form
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])
    ->name('password.reset');

// Handle Reset Password Submission 
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Delete Account
Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])
    ->middleware('auth')
    ->name('account.delete');

// Update Password from Profile Settings
Route::post('/account/update-password', [AuthController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('account.update-password');

Route::get('/adminpage', function () {
    return view('adminpage');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/admin/contributors', function () {
    return view('admin.contributors');
})->name('contributors');

Route::get('/admin/activity', function () {
    return view('admin.activity');
})->name('activity');

Route::get('/admin/reports', function () {
    return view('admin.reports');
})->name('reports');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/adminpage', [AdminController::class, 'index'])->name('adminpage');
    Route::get('/admin/contributors', [AdminController::class, 'contributors'])->name('contributors');
    Route::get('/admin/activity', [AdminController::class, 'activity'])->name('activity');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('settings');
});