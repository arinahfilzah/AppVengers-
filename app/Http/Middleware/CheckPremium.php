<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPremium
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user has premium access
        if (!$user->isPremium()) {
            return redirect()->route('premium.plans')
                ->with('error', 'This feature requires premium access. Please upgrade your account.');
        }

        return $next($request);
    }
}