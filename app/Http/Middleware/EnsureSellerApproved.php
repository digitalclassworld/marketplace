<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerApproved
{
    /**
     * Handle an incoming request for protected seller operations (upload, create, publish, sell).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('seller.login'))
                ->with('error', 'Please log in to continue.');
        }

        $user = Auth::user();

        // Allow Super Admin full access to selling features
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('seller.register')
                ->with('error', 'Seller profile not found. Please register as a seller first.');
        }

        if ($seller->isPendingApproval()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your seller account is awaiting Super Admin approval.',
                ], 403);
            }

            return redirect()->route('seller.dashboard')
                ->with('error', 'Your seller account is awaiting Super Admin approval.');
        }

        if ($seller->isRejected()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your seller account was rejected. You cannot create or publish listings.',
                ], 403);
            }

            return redirect()->route('seller.dashboard')
                ->with('error', 'Your seller account was rejected. You cannot create or publish listings.');
        }

        if ($seller->isSuspended()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your seller account is suspended. Listing publishing is restricted.',
                ], 403);
            }

            return redirect()->route('seller.dashboard')
                ->with('error', 'Your seller account is suspended. Listing publishing is restricted.');
        }

        if (!$seller->isActive()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your seller account is inactive or not approved for selling.',
                ], 403);
            }

            return redirect()->route('seller.dashboard')
                ->with('error', 'Your seller account is inactive or not approved for selling.');
        }

        return $next($request);
    }
}

