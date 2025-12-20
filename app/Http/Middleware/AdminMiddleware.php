<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You need to log in to access this page.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'You do not have the necessary permissions to access this page.');
        }

        // Allow access if the user is an admin
        return $next($request);
    }
}
