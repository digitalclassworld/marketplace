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
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->isSuperAdmin()) {
            Auth::shouldUse('admin');
            return $next($request);
        }

        $webUser = Auth::guard('web')->user();
        if ($webUser && $webUser->isSuperAdmin()) {
            Auth::guard('admin')->login($webUser);
            Auth::shouldUse('admin');
            return $next($request);
        }

        return redirect()->route('admin.login')
            ->with('error', 'Please log in to access the Super Admin Portal.');
    }
}
