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

        // Super Admin has full administrative access to view and use the Seller Portal
        if ($user->isSuperAdmin()) {
            $seller = $user->seller;
            if (!$seller) {
                try {
                    $seller = \App\Models\Seller::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'seller_code'         => 'DC-ADMIN-000001',
                            'account_type'        => \App\Models\Seller::ACCOUNT_TYPE_INSTITUTE,
                            'seller_status'       => \App\Models\Seller::STATUS_ACTIVE,
                            'verification_status' => \App\Models\Seller::VERIFICATION_VERIFIED,
                            'registration_date'   => now(),
                            'approved_at'         => now(),
                            'approved_by'         => $user->id,
                        ]
                    );
                    \App\Models\SellerBusinessDetail::firstOrCreate(
                        ['seller_id' => $seller->id],
                        [
                            'business_name' => 'Digital Class Official Store',
                            'category'      => 'Technology & Education',
                            'city'          => 'Ahmedabad',
                        ]
                    );
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Error creating seller profile for superadmin: ' . $e->getMessage());
                }
            }
            return $next($request);
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
