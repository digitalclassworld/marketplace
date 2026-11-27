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

    public function test_student_can_view_my_services_page()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.services'));
        $response->assertStatus(200);
        $response->assertSee('My Hired Services');
        $response->assertSee('Explore More Services');
    }

    public function test_student_can_view_my_business_inquiries_page()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.businesses'));
        $response->assertStatus(200);
        $response->assertSee('My Business Inquiries');
        $response->assertSee('Explore Businesses');
    }

    public function test_student_can_view_wishlist_page_and_remove_item()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.wishlist'));
        $response->assertStatus(200);
        $response->assertSee('My Wishlist');
        $response->assertSee('Browse More Courses');

        // Test removing an item
        $removeResponse = $this->actingAs($this->student, 'web')
            ->post(route('customer.wishlist.remove', ['id' => 1]));
        $removeResponse->assertRedirect();
        $removeResponse->assertSessionHas('success');

        // Test clearing all items
        $clearResponse = $this->actingAs($this->student, 'web')
            ->post(route('customer.wishlist.clear'));
        $clearResponse->assertRedirect();
        $clearResponse->assertSessionHas('success');
    }

    public function test_student_can_view_messages_page_and_send_message()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.messages'));
        $response->assertStatus(200);
        $response->assertSee('Messages &amp; Support Desk', false);
        $response->assertSee('Send a Message to Support');
        $response->assertDontSee('<span class="dc-nav-badge">5</span>', false);

        // Test sending message
        $sendResponse = $this->actingAs($this->student, 'web')
            ->post(route('customer.messages.send'), [
                'subject' => 'Need help with certificate verification',
                'message' => 'Please assist me with downloading my completed course certificate.',
            ]);
        $sendResponse->assertRedirect();
        $sendResponse->assertSessionHas('success');
    }
}
