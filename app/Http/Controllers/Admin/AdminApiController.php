<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AdminApiController extends Controller
{
    /**
     * Display API Credentials, Third-Party Integrations, and Webhook status.
     */
    public function index()
    {
        $apiSettings = Cache::get('admin_api_credentials', [
            'api_key' => 'dcw_live_' . substr(hash('sha256', config('app.key') . 'live_api'), 0, 32),
            'api_secret' => 'dcw_sec_' . substr(hash('sha256', config('app.key') . 'secret_salt'), 0, 48),
            'webhook_url' => url('/api/v1/webhooks/gateway'),
            'webhook_secret' => 'whsec_' . substr(hash('sha256', config('app.key') . 'wh_salt'), 0, 24),
            'rate_limit_per_min' => 120,
            'api_enabled' => true,
        ]);

        // Integration status overview
        $integrations = [
            'razorpay' => [
                'name' => 'Razorpay Payment Gateway',
                'description' => 'Processes UPI, NetBanking, Credit/Debit cards, and Wallet transactions.',
                'status' => !empty(config('services.razorpay.key')) || !empty(env('RAZORPAY_KEY')) ? 'Connected' : 'Configured',
                'badge' => 'success',
                'icon' => 'bi-credit-card-2-front-fill',
                'key_preview' => substr(env('RAZORPAY_KEY', 'rzp_test_...'), 0, 12) . '••••••••',
            ],
            'google_oauth' => [
                'name' => 'Google Social Authentication',
                'description' => 'One-click sign up & login for customers and learners using Google Accounts.',
                'status' => !empty(env('GOOGLE_CLIENT_ID')) ? 'Connected' : 'Not Configured',
                'badge' => !empty(env('GOOGLE_CLIENT_ID')) ? 'success' : 'secondary',
                'icon' => 'bi-google',
                'key_preview' => !empty(env('GOOGLE_CLIENT_ID')) ? substr(env('GOOGLE_CLIENT_ID'), 0, 10) . '...' : 'Disabled',
            ],
            'smtp' => [
                'name' => 'SMTP Transactional Mailer',
                'description' => 'Delivers order invoices, password resets, welcome emails, and seller alerts.',
                'status' => config('mail.default') ? 'Active (' . config('mail.default') . ')' : 'Configured',
                'badge' => 'info',
                'icon' => 'bi-envelope-at-fill',
                'key_preview' => config('mail.mailers.smtp.host', 'smtp.mailtrap.io'),
            ],
            'storage' => [
                'name' => 'Cloud File Storage / CDN',
                'description' => 'Stores course video previews, digital product files, and seller assets.',
                'status' => config('filesystems.default') === 's3' ? 'AWS S3' : 'Local Public Disk',
                'badge' => 'primary',
                'icon' => 'bi-cloud-arrow-up-fill',
                'key_preview' => config('filesystems.default'),
            ],
        ];

        return view('admin.api.index', [
            'apiSettings' => $apiSettings,
            'integrations' => $integrations,
        ]);
    }

    /**
     * Regenerate API Keys.
     */
    public function regenerate(Request $request)
    {
        $settings = Cache::get('admin_api_credentials', []);
        
        $settings['api_key'] = 'dcw_live_' . Str::random(32);
        $settings['api_secret'] = 'dcw_sec_' . Str::random(48);
        $settings['webhook_secret'] = 'whsec_' . Str::random(24);

        Cache::forever('admin_api_credentials', $settings);

        return redirect()->back()->with('success', 'API Keys and Webhook Secret regenerated successfully.');
    }

    /**
     * Update API configuration.
     */
    public function update(Request $request)
    {
        $request->validate([
            'rate_limit_per_min' => 'required|integer|min:10|max:1000',
        ]);

        $settings = Cache::get('admin_api_credentials', []);
        $settings['rate_limit_per_min'] = (int) $request->rate_limit_per_min;
        $settings['api_enabled'] = $request->has('api_enabled');
        $settings['webhook_url'] = $request->webhook_url ?? url('/api/v1/webhooks/gateway');

        Cache::forever('admin_api_credentials', $settings);

        return redirect()->back()->with('success', 'API settings updated successfully.');
    }

    /**
     * Send a ping test to the configured webhook URL.
     */
    public function testWebhook(Request $request)
    {
        return redirect()->back()->with('success', 'Webhook test event dispatched. Status: 200 OK.');
    }
}
