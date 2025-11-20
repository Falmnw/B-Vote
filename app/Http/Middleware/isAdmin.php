<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $adminEmail = env('ADMIN_EMAIL');
        if (!$user || $user->email !== $adminEmail) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
