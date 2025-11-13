<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/account', function () {
    return view('account');
})->name('account');

Route::get('/uploadResource', function () {
    return view('uploadResource');
})->name('uploadResource');

Route::get('/course', function () {
    return view('course');
})->name('course');

// -------------------
// Authentication (UI only)
// -------------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset', function () {
    return view('auth.reset');
})->name('password.reset');
