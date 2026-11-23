<?php

namespace Tests\Feature;

use App\Models\BusinessListing;
use App\Models\Seller;
use App\Models\User;
use App\Services\SellerIdService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_profile_loads_successfully(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000001',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        $listing = BusinessListing::create([
            'seller_id'     => $seller->id,
            'business_name' => 'VCEC - Vinayak Computer Education Center',
            'slug'          => 'vcec-vinayak-computer-education-center',
            'category'      => 'Computer Training',
            'listing_type'  => 'Featured',
            'city'          => 'Ahmedabad',
            'phone'         => '+91 98765 43210',
            'status'        => 'approved',
            'approved_at'   => now(),
        ]);

        $response = $this->followingRedirects()->get('/business/' . $listing->slug);

        $response->assertStatus(200);
        $response->assertSee('VCEC - Vinayak Computer Education Center');
        $response->assertSee('About VCEC');
        $response->assertSee('Key Information');
        $response->assertSee('Courses');
        $response->assertSee('Overview');
    }

    public function test_enquiry_submission_works(): void
    {
        $response = $this->post('/business/vcec-vinayak-computer-education-center/enquiry', [
            'name' => 'Aarav Mehta',
            'phone' => '+91 98765 43210',
            'course' => 'Digital Marketing Complete Course',
            'message' => 'Interested in weekend batches',
        ]);

        $response->assertSessionHas('success');
    }

    public function test_demo_booking_works(): void
    {
        $response = $this->post('/business/vcec-vinayak-computer-education-center/demo', [
            'name' => 'Rohan Patel',
            'phone' => '+91 98765 43210',
            'course' => 'Full Stack Web Development',
            'preferred_branch' => 'Nikol Branch (Head Office)',
        ]);

        $response->assertSessionHas('success');
    }

    public function test_customer_login_links_directly_to_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('customer.login'), false);
        $response->assertDontSee("onclick=\"openCustomerAuthModal('login')\"", false);
    }

    public function test_paid_plan_business_listings_are_prioritized(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = Seller::create([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000002',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);

        // Create Free listing first
        $freeListing = BusinessListing::create([
            'seller_id'     => $seller->id,
            'business_name' => 'Free Academy',
            'slug'          => 'free-academy',
            'category'      => 'Education',
            'listing_type'  => 'Free',
            'plan_name'     => 'Free Listing',
            'plan_price'    => 0,
            'city'          => 'Ahmedabad',
            'status'        => 'approved',
            'approved_at'   => now(),
        ]);

        // Create Premium listing
        $premiumListing = BusinessListing::create([
            'seller_id'     => $seller->id,
            'business_name' => 'Premium Academy',
            'slug'          => 'premium-academy',
            'category'      => 'Education',
            'listing_type'  => 'Premium',
            'plan_name'     => 'Premium Listing',
            'plan_price'    => 1499,
            'city'          => 'Ahmedabad',
            'status'        => 'approved',
            'approved_at'   => now(),
        ]);

        // Create Featured listing
        $featuredListing = BusinessListing::create([
            'seller_id'     => $seller->id,
            'business_name' => 'Featured Elite Institute',
            'slug'          => 'featured-elite-institute',
            'category'      => 'Education',
            'listing_type'  => 'Featured',
            'plan_name'     => 'Featured Listing',
            'plan_price'    => 2999,
            'city'          => 'Ahmedabad',
            'status'        => 'approved',
            'approved_at'   => now(),
        ]);

        $this->assertEquals(1, $featuredListing->priority_rank);
        $this->assertEquals(2, $premiumListing->priority_rank);
        $this->assertEquals(3, $freeListing->priority_rank);

        $this->assertTrue($premiumListing->hasHighSupport());
        $this->assertTrue($featuredListing->hasHighSupport());
        $this->assertFalse($freeListing->hasHighSupport());

        $response = $this->get('/businesses');
        $response->assertStatus(200);

        // Verify Featured and Premium badges render
        $response->assertSee('Featured');
        $response->assertSee('Premium');
        $response->assertSee('High Support');
        $response->assertSee('Top Suggestion');

        // Check relative ordering in the HTML response
        $content = $response->getContent();
        $posFeatured = strpos($content, 'Featured Elite Institute');
        $posPremium = strpos($content, 'Premium Academy');
        $posFree = strpos($content, 'Free Academy');

        $this->assertNotFalse($posFeatured);
        $this->assertNotFalse($posPremium);
        $this->assertNotFalse($posFree);

        // Featured must come before Premium, and Premium must come before Free
        $this->assertTrue($posFeatured < $posPremium, 'Featured listing must appear before Premium listing');
        $this->assertTrue($posPremium < $posFree, 'Premium listing must appear before Free listing');
    }
}
