<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSidebarModulesTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Find or create an admin user
        $this->admin = User::where('role', 'admin')->orWhere('role', 'superadmin')->first();
        if (!$this->admin) {
            $this->admin = User::factory()->create([
                'role' => 'admin',
                'email' => 'admin_test@digitalclassworld.in',
            ]);
        }
    }

    public function test_all_sidebar_admin_modules_render_successfully()
    {
        $routes = [
            // Core
            'admin.dashboard',
            'admin.users.index',
            'admin.sellers.index',

            // Catalog
            'admin.catalog.courses',
            'admin.catalog.services',
            'admin.catalog.products',
            'admin.catalog.listings',

            // Orders
            'admin.orders.index',

            // Financial
            'admin.financial.payments',
            'admin.financial.payouts',
            'admin.financial.refunds',

            // Growth & Marketing
            'admin.promotions.index',
            'admin.coupons.index',
            'admin.reviews.index',
            'admin.messages.index',
            'admin.leads.index',

            // Content
            'admin.cms.index',
            'admin.notifications.index',

            // SEO & Traffic
            'admin.seo.index',

            // App & Platform
            'admin.app.index',
            'admin.website.index',
            'admin.modules.index',
            'admin.api.index',

            // Reports & System
            'admin.reports.index',
            'admin.settings.index',
            'admin.roles.index',
            'admin.activity.index',
        ];

        foreach ($routes as $routeName) {
            $url = route($routeName);
            $response = $this->actingAs($this->admin)->get($url);
            $this->assertEquals(
                200, 
                $response->getStatusCode(), 
                "Route [{$routeName}] at URL [{$url}] failed with status: " . $response->getStatusCode()
            );
        }
    }

    public function test_feature_actions_work()
    {
        // Test module toggle
        $response = $this->actingAs($this->admin)->post(route('admin.modules.toggle', 'courses'));
        $response->assertRedirect();

        // Test settings update
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'site_name' => 'Digital Class World Marketplace',
            'support_email' => 'support@digitalclassworld.in',
            'commission_rate' => 10,
            'payout_threshold' => 1000,
        ]);
        $response->assertRedirect();

        // Test API key regeneration
        $response = $this->actingAs($this->admin)->post(route('admin.api.regenerate'));
        $response->assertRedirect();

        // Test Webhook test
        $response = $this->actingAs($this->admin)->post(route('admin.api.test-webhook'));
        $response->assertRedirect();

        // Test Staff creation
        $response = $this->actingAs($this->admin)->post(route('admin.roles.staff.store'), [
            'name' => 'Security Audit Bot',
            'email' => 'audit_' . uniqid() . '@digitalclassworld.in',
            'role' => 'admin',
            'password' => 'SecurePass123!@#',
        ]);
        $response->assertRedirect();
    }
}

