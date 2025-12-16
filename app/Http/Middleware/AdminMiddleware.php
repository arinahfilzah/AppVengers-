<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        \Log::info('=== ADMIN MIDDLEWARE HIT ===');
    \Log::info('URL: ' . $request->fullUrl());
    \Log::info('User ID: ' . (Auth::id() ?? 'null'));
    
    if (Auth::check()) {
        \Log::info('User role: ' . Auth::user()->role);
        \Log::info('User data: ' . json_encode(Auth::user()->toArray()));
    }
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Check if user has admin role (using 'role' column, not 'is_admin')
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }
    }
}