<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
