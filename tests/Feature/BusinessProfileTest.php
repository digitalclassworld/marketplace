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

        $response = $this->get('/business/' . $listing->slug);

        $response->assertStatus(200);
        $response->assertSee('VCEC - Vinayak Computer Education Center');
        $response->assertSee('About VCEC');
        $response->assertSee('Popular Courses');
        $response->assertSee('Our Services');
        $response->assertSee('Student Reviews');
        $response->assertSee('Visit Our Branch');
        $response->assertSee('Book a Free Demo Class');
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
}
