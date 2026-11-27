<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class StudentDashboardPanelTest extends TestCase
{
    protected $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->student = User::where('role', 'customer')->first();
        if (!$this->student) {
            $this->student = User::factory()->create([
                'name'       => 'Hitesh Mohkar',
                'email'      => 'hitesh_student_' . uniqid() . '@example.com',
                'role'       => 'customer',
                'profession' => 'Student',
            ]);
        }
    }

    public function test_student_can_view_dashboard_matching_pdf_layout()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.dashboard'));
        $response->assertStatus(200);

        // Sidebar Navigation
        $response->assertSee('Digital Class');
        $response->assertSee('Marketplace');
        $response->assertSee('Dashboard');
        $response->assertSee('My Learning');
        $response->assertSee('My Orders');
        $response->assertSee('My Services');
        $response->assertSee('My Business Inquiries');
        $response->assertSee('Wishlist');
        $response->assertSee('Messages');
        $response->assertSee('Refer &amp; Earn', false);
        $response->assertSee('Need Help?');

        // Hero Banner
        $response->assertSee('Learn, Hire, Buy &amp; Discover', false);
        $response->assertSee('Everything in One Place');

        // 4 Category Showcase Cards
        $response->assertSee('Online Courses');
        $response->assertSee('Professional Services');
        $response->assertSee('Products');
        $response->assertSee('Business Directory');

        // Continue Learning Section
        $response->assertSee('Continue Learning');

        // My Orders Section
        $response->assertSee('My Orders');

        // Recommended for You Section
        $response->assertSee('Recommended for You');

        // Popular Categories
        $response->assertSee('Popular Categories');
    }

    public function test_guest_can_view_dashboard_preview_or_redirect()
    {
        $response = $this->get(route('customer.dashboard'));
        // Public preview allows guest or redirects
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }
}
