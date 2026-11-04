<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRegistrationRequest;
use App\Models\Seller;
use App\Models\SellerBusinessDetail;
use App\Models\User;
use App\Services\SellerIdService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SellerRegistrationController extends Controller
{
    protected SellerIdService $sellerIdService;

    public function __construct(SellerIdService $sellerIdService)
    {
        $this->sellerIdService = $sellerIdService;
    }

    /**
     * Show the 4-step seller registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.seller-register');
    }

    /**
     * Process seller registration with database transaction and automatic Seller ID generation.
     */
    public function register(SellerRegistrationRequest $request): View|RedirectResponse
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // 1. Create User account
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role'     => 'seller',
            ]);

            // 2. Create Seller record with a temporary unique code
            $seller = new Seller([
                'user_id'             => $user->id,
                'seller_code'         => SellerIdService::generateTempCode(),
                'account_type'        => $validated['account_type'],
                'seller_status'       => Seller::STATUS_PENDING_APPROVAL,
                'verification_status' => Seller::VERIFICATION_NOT_VERIFIED,
                'registration_date'   => now(),
            ]);
            $seller->save();

            // 3. Assign permanent formatted Seller ID: DC-SELL-00000X
            $this->sellerIdService->assignSellerCode($seller);

            // 4. Create Seller Business Details
            $businessName = $validated['business_name'] ?? null;
            if (empty($businessName)) {
                $businessName = ($validated['account_type'] === Seller::ACCOUNT_TYPE_INDIVIDUAL)
                    ? $validated['name']
                    : ($validated['name'] . "'s Store");
            }

            SellerBusinessDetail::create([
                'seller_id'            => $seller->id,
                'business_name'        => $businessName,
                'business_email'       => $validated['business_email'] ?? $validated['email'],
                'business_phone'       => $validated['business_phone'] ?? $validated['phone'],
                'business_category'    => $validated['business_category'] ?? null,
                'business_description' => $validated['business_description'] ?? null,
                'website'              => $validated['website'] ?? null,
                'address'              => $validated['address'] ?? null,
                'city'                 => $validated['city'] ?? null,
                'state'                => $validated['state'] ?? null,
                'country'              => 'India',
                'pincode'              => $validated['pincode'] ?? null,
            ]);

            DB::commit();

            // Clear any previous session and log in the newly registered seller
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::login($user);

            // Store success details in session for the Go-Live / confirmation view
            session()->flash('registered_seller', [
                'seller_id'           => $seller->seller_code,
                'name'                => $user->name,
                'business_name'       => $businessName,
                'account_type'        => $seller->account_type,
                'registration_date'   => $seller->registration_date->format('d M, Y H:i A'),
                'seller_status'       => $seller->seller_status,
                'verification_status' => $seller->verification_status,
            ]);

            return redirect()->route('seller.register.success');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Seller Registration Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Registration failed due to a server error. Please try again.');
        }
    }

    /**
     * Show Go Live / Registration Success Page (Step 4)
     */
    public function success(): View|RedirectResponse
    {
        $sellerData = session('registered_seller');

        // If accessed directly without session flash, pull from authenticated seller
        if (!$sellerData && Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
            $sellerData = [
                'seller_id'           => $seller->seller_code,
                'name'                => Auth::user()->name,
                'business_name'       => $seller->businessDetail?->business_name ?? Auth::user()->name,
                'account_type'        => $seller->account_type,
                'registration_date'   => $seller->registration_date ? $seller->registration_date->format('d M, Y H:i A') : now()->format('d M, Y H:i A'),
                'seller_status'       => $seller->seller_status,
                'verification_status' => $seller->verification_status,
            ];
        }

        if (!$sellerData) {
            return redirect()->route('seller.register');
        }

        return view('auth.seller-register-success', [
            'seller' => $sellerData,
        ]);
    }
}

