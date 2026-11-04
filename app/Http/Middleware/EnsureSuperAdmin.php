<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the Super Admin Portal.');
        }

        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Unauthorized access. Super Admin credentials required.');
        }

        return $next($request);
    }
}
