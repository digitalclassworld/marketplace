<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminModuleController extends Controller
{
    /**
     * Default list of modular platform capabilities.
     */
    protected function defaultModules(): array
    {
        return [
            'courses' => [
                'name' => 'Courses Marketplace',
                'description' => 'Online video courses, chapters, curricula, and instructor student enrollment engine.',
                'icon' => 'bi-journal-code',
                'category' => 'Core Marketplace',
                'enabled' => true,
                'configurable' => true,
            ],
            'services' => [
                'name' => 'Services & Freelance Booking',
                'description' => 'Professional consultation, custom service requests, milestones, and direct seller booking.',
                'icon' => 'bi-briefcase-fill',
                'category' => 'Core Marketplace',
                'enabled' => true,
                'configurable' => true,
            ],
            'products' => [
                'name' => 'Digital & Physical Products Store',
                'description' => 'E-commerce downloadable assets, software, physical books, and merchandise ordering.',
                'icon' => 'bi-box-seam-fill',
                'category' => 'Core Marketplace',
                'enabled' => true,
                'configurable' => true,
            ],
            'listings' => [
                'name' => 'Coaching & Business Directory',
                'description' => 'Public institute profiles, verified coaching centers, location search, and lead capture.',
                'icon' => 'bi-building',
                'category' => 'Directory',
                'enabled' => true,
                'configurable' => true,
            ],
            'coupons' => [
                'name' => 'Coupons & Promotional Discounts',
                'description' => 'Checkout discount codes, percentage and flat discounts with min spend constraints.',
                'icon' => 'bi-ticket-perforated-fill',
                'category' => 'Marketing',
                'enabled' => true,
                'configurable' => true,
            ],
            'cms' => [
                'name' => 'Blog & Content Management (CMS)',
                'description' => 'Articles, knowledge base, SEO content publishing, and customer guides.',
                'icon' => 'bi-file-earmark-richtext',
                'category' => 'Content & Growth',
                'enabled' => true,
                'configurable' => true,
            ],
            'reviews' => [
                'name' => 'Customer Reviews & Star Ratings',
                'description' => 'Verified buyer feedback, moderation queue, and public aggregate rating stars.',
                'icon' => 'bi-star-fill',
                'category' => 'Trust & Community',
                'enabled' => true,
                'configurable' => true,
            ],
            'messaging' => [
                'name' => 'Live Chat & Support Tickets',
                'description' => 'Direct buyer-seller messaging, admin support desk, and moderation tickets.',
                'icon' => 'bi-chat-dots-fill',
                'category' => 'Communication',
                'enabled' => true,
                'configurable' => true,
            ],
            'seller_registration' => [
                'name' => 'Self-Serve Seller Registration',
                'description' => 'Allow new creators, institutes, and agencies to onboard and open seller storefronts.',
                'icon' => 'bi-person-badge-fill',
                'category' => 'Sellers',
                'enabled' => true,
                'configurable' => true,
            ],
            'auto_payouts' => [
                'name' => 'Automated Payout Processing',
                'description' => 'Automatic batch payouts when seller balances exceed threshold.',
                'icon' => 'bi-cash-stack',
                'category' => 'Financial',
                'enabled' => false,
                'configurable' => true,
            ],
        ];
    }

    /**
     * Display all marketplace feature modules and their switches.
     */
    public function index()
    {
        $saved = Cache::get('admin_marketplace_modules', []);
        $modules = $this->defaultModules();

        // Merge saved statuses
        foreach ($modules as $key => &$mod) {
            if (isset($saved[$key])) {
                $mod['enabled'] = (bool) $saved[$key];
            }
        }

        $activeCount = collect($modules)->where('enabled', true)->count();
        $totalCount = count($modules);

        return view('admin.modules.index', [
            'modules' => $modules,
            'activeCount' => $activeCount,
            'totalCount' => $totalCount,
        ]);
    }

    /**
     * Toggle a single feature module on or off.
     */
    public function toggle(Request $request, $key)
    {
        $saved = Cache::get('admin_marketplace_modules', []);
        $modules = $this->defaultModules();

        if (!array_key_exists($key, $modules)) {
            return redirect()->back()->with('error', 'Module not recognized.');
        }

        $currentState = isset($saved[$key]) ? (bool)$saved[$key] : $modules[$key]['enabled'];
        $newState = !$currentState;
        $saved[$key] = $newState;

        Cache::forever('admin_marketplace_modules', $saved);

        $moduleName = $modules[$key]['name'];
        $statusText = $newState ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "{$moduleName} has been {$statusText} successfully.");
    }

    /**
     * Batch update module settings.
     */
    public function update(Request $request)
    {
        $modules = $this->defaultModules();
        $saved = [];

        foreach (array_keys($modules) as $key) {
            $saved[$key] = $request->has("module_{$key}");
        }

        Cache::forever('admin_marketplace_modules', $saved);

        return redirect()->back()->with('success', 'Marketplace feature modules configuration updated successfully.');
    }
}
