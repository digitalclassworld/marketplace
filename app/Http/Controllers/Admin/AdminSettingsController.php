<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /**
     * Display Platform General Settings Studio.
     */
    public function index(): View
    {
        $settings = Cache::get('admin_platform_settings', [
            'site_name'            => config('app.name', 'Digital Class'),
            'site_tagline'         => 'India\'s Premier Educational & Digital Learning Marketplace',
            'support_email'        => 'support@digitalclassworld.in',
            'contact_phone'        => '+91 98765 43210',
            'office_address'       => 'Ahmedabad, Gujarat, India',
            'default_currency'     => 'INR (₹)',
            'commission_rate'      => 15,
            'min_payout_threshold' => 500,
            'razorpay_key'         => env('RAZORPAY_KEY', 'rzp_live_dc_marketplace'),
            'razorpay_secret'      => '••••••••••••••••',
            'google_client_id'     => env('GOOGLE_CLIENT_ID', ''),
            'maintenance_mode'     => false,
            'allow_registration'   => true,
            'auto_approve_sellers' => false,
        ]);

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update Platform General Settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name'            => 'required|string|max:100',
            'site_tagline'         => 'nullable|string|max:200',
            'support_email'        => 'required|email|max:100',
            'contact_phone'        => 'nullable|string|max:50',
            'office_address'       => 'nullable|string|max:255',
            'commission_rate'      => 'required|numeric|min:0|max:100',
            'min_payout_threshold' => 'required|numeric|min:0',
            'razorpay_key'         => 'nullable|string|max:100',
            'maintenance_mode'     => 'nullable|boolean',
            'allow_registration'   => 'nullable|boolean',
            'auto_approve_sellers' => 'nullable|boolean',
        ]);

        $settings = [
            'site_name'            => $request->input('site_name'),
            'site_tagline'         => $request->input('site_tagline'),
            'support_email'        => $request->input('support_email'),
            'contact_phone'        => $request->input('contact_phone'),
            'office_address'       => $request->input('office_address'),
            'default_currency'     => 'INR (₹)',
            'commission_rate'      => (float) $request->input('commission_rate', 15),
            'min_payout_threshold' => (float) $request->input('min_payout_threshold', 500),
            'razorpay_key'         => $request->input('razorpay_key'),
            'razorpay_secret'      => '••••••••••••••••',
            'google_client_id'     => $request->input('google_client_id', ''),
            'maintenance_mode'     => $request->boolean('maintenance_mode', false),
            'allow_registration'   => $request->boolean('allow_registration', true),
            'auto_approve_sellers' => $request->boolean('auto_approve_sellers', false),
        ];

        Cache::forever('admin_platform_settings', $settings);

        return redirect()->route('admin.settings.index')->with('success', 'Platform settings updated and cached successfully.');
    }
}
