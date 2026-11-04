<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('seller.login')
                ->with('error', 'Please log in to access your Seller Dashboard.');
        }

        $user = Auth::user();

        // If Super Admin tries to access the seller dashboard, direct them to the Super Admin Dashboard
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'You are currently logged in as Super Admin. The Seller Portal is exclusively for registered sellers.');
        }

        if (!$user->isSeller()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('seller.login')
                ->with('error', 'Access restricted. Only seller accounts can access this portal.');
        }

        $seller = $user->seller;
        if (!$seller) {
            return redirect()->route('seller.register')
                ->with('error', 'No seller profile found. Please complete seller registration.');
        }

        if ($seller->isInactive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('seller.login')
                ->with('error', 'Your seller account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}
