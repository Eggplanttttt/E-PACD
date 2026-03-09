<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('login');
        }

        $response = $next($request);

        // Prevent browser caching
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
