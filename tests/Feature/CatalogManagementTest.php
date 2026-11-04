<?php

namespace Tests\Feature;

use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createApprovedSeller(): array
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = Seller::create([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-TEST-1001',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
            'approved_at'         => now(),
        ]);

        return [$user, $seller];
    }

    private function createPendingSeller(): array
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = Seller::create([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-PEND-2002',
            'account_type'        => Seller::ACCOUNT_TYPE_INDIVIDUAL,
            'seller_status'       => Seller::STATUS_PENDING_APPROVAL,
            'verification_status' => Seller::VERIFICATION_PENDING,
            'registration_date'   => now(),
        ]);

        return [$user, $seller];
    }

    private function createAdminUser(): User
    {
        return User::factory()->create(['role' => 'superadmin']);
    }

    public function test_approved_seller_can_access_catalog_creation_pages(): void
    {
        [$user, $seller] = $this->createApprovedSeller();

        $this->actingAs($user)->get(route('seller.courses.create'))->assertStatus(200);
        $this->actingAs($user)->get(route('seller.services.create'))->assertStatus(200);
        $this->actingAs($user)->get(route('seller.products.create'))->assertStatus(200);
        $this->actingAs($user)->get(route('seller.listings.create'))->assertStatus(200);
    }

    public function test_pending_seller_cannot_access_catalog_creation_pages(): void
    {
        [$user, $seller] = $this->createPendingSeller();

        $this->actingAs($user)->get(route('seller.courses.create'))->assertRedirect(route('seller.dashboard'));
        $this->actingAs($user)->get(route('seller.services.create'))->assertRedirect(route('seller.dashboard'));
        $this->actingAs($user)->get(route('seller.products.create'))->assertRedirect(route('seller.dashboard'));
        $this->actingAs($user)->get(route('seller.listings.create'))->assertRedirect(route('seller.dashboard'));
    }

    public function test_seller_can_submit_course_with_lectures_as_pending(): void
    {
        [$user, $seller] = $this->createApprovedSeller();

        $response = $this->actingAs($user)->post(route('seller.courses.store'), [
            'title'             => 'Complete Digital Marketing Course',
            'category'          => 'Digital Marketing',
            'language'          => 'Hindi',
            'level'             => 'Beginner',
            'short_description' => 'Learn digital marketing from basics to advanced with practical examples.',
            'price'             => 2999.00,
            'discount_price'    => 1999.00,
            'access_type'       => 'Lifetime Access',
            'sections'          => [
                [
                    'section_title' => '1. Introduction to Digital Marketing',
                    'lecture_title' => '1.1 What is Digital Marketing?',
                    'duration'      => '12:30',
                ],
                [
                    'section_title' => '1. Introduction to Digital Marketing',
                    'lecture_title' => '1.2 Types of Digital Marketing',
                    'duration'      => '15:20',
                ],
            ],
        ]);

        $response->assertRedirect(route('seller.courses.index'));

        $this->assertDatabaseHas('courses', [
            'seller_id' => $seller->id,
            'title'     => 'Complete Digital Marketing Course',
            'status'    => 'pending',
            'price'     => 2999.00,
        ]);

        $this->assertDatabaseHas('course_contents', [
            'lecture_title' => '1.1 What is Digital Marketing?',
            'duration'      => '12:30',
        ]);
    }

    public function test_seller_can_submit_service_gig_as_pending(): void
    {
        [$user, $seller] = $this->createApprovedSeller();

        $response = $this->actingAs($user)->post(route('seller.services.store'), [
            'title'              => 'Professional Logo Design Service',
            'category'           => 'Graphic Design',
            'short_description'  => 'Get a unique and professional logo for your business.',
            'tags'               => 'logo design, branding, business',
            'delivery_days'      => 3,
            'package_name'       => 'Basic',
            'price'              => 1999.00,
            'buyer_requirements' => '1. Your business name 2. Preferred color scheme',
        ]);

        $response->assertRedirect(route('seller.services.index'));

        $this->assertDatabaseHas('services', [
            'seller_id' => $seller->id,
            'title'     => 'Professional Logo Design Service',
            'status'    => 'pending',
            'price'     => 1999.00,
        ]);
    }

    public function test_seller_can_submit_product_as_pending(): void
    {
        [$user, $seller] = $this->createApprovedSeller();

        $response = $this->actingAs($user)->post(route('seller.products.store'), [
            'title'          => 'Wireless Ergonomic Mouse',
            'category'       => 'Digital Assets & Tools',
            'product_type'   => 'Digital',
            'description'    => 'High performance productivity tool.',
            'price'          => 499.00,
            'mrp'            => 999.00,
            'stock_quantity' => 50,
        ]);

        $response->assertRedirect(route('seller.products.index'));

        $this->assertDatabaseHas('products', [
            'seller_id' => $seller->id,
            'title'     => 'Wireless Ergonomic Mouse',
            'status'    => 'pending',
            'price'     => 499.00,
        ]);
    }

    public function test_seller_can_submit_business_listing_as_pending(): void
    {
        [$user, $seller] = $this->createApprovedSeller();

        $response = $this->actingAs($user)->post(route('seller.listings.store'), [
            'business_name' => 'Apex Academy of Code',
            'category'      => 'Educational Institute',
            'tagline'       => 'Empowering Tech Careers',
            'city'          => 'Ahmedabad',
            'state'         => 'Gujarat',
            'pincode'       => '380015',
        ]);

        $response->assertRedirect(route('seller.listings.index'));

        $this->assertDatabaseHas('business_listings', [
            'seller_id'     => $seller->id,
            'business_name' => 'Apex Academy of Code',
            'status'        => 'pending',
        ]);
    }

    public function test_super_admin_can_use_entire_seller_portal_and_catalog_creation(): void
    {
        $admin = $this->createAdminUser();

        // 1. Super Admin can view Seller Dashboard
        $this->actingAs($admin)->get(route('seller.dashboard'))->assertStatus(200);

        // 2. Super Admin can view Seller Profile
        $this->actingAs($admin)->get(route('seller.profile'))->assertStatus(200);

        // 3. Super Admin can access all index and creation pages
        $this->actingAs($admin)->get(route('seller.courses.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('seller.courses.create'))->assertStatus(200);

        $this->actingAs($admin)->get(route('seller.services.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('seller.services.create'))->assertStatus(200);

        $this->actingAs($admin)->get(route('seller.products.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('seller.products.create'))->assertStatus(200);

        $this->actingAs($admin)->get(route('seller.listings.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('seller.listings.create'))->assertStatus(200);

        // 4. Super Admin can create Course
        $this->actingAs($admin)->post(route('seller.courses.store'), [
            'title'       => 'Admin Master Course',
            'category'    => 'Digital Marketing',
            'language'    => 'English',
            'level'       => 'All Levels',
            'price'       => 999.00,
            'access_type' => 'Lifetime Access',
        ])->assertRedirect(route('seller.courses.index'));

        // 5. Super Admin can create Service
        $this->actingAs($admin)->post(route('seller.services.store'), [
            'title'         => 'Admin Professional Gig',
            'category'      => 'Graphic Design',
            'delivery_days' => 2,
            'package_name'  => 'Standard',
            'price'         => 1499.00,
        ])->assertRedirect(route('seller.services.index'));

        // 6. Super Admin can create Product
        $this->actingAs($admin)->post(route('seller.products.store'), [
            'title'          => 'Admin Digital Template',
            'category'       => 'Digital Assets & Tools',
            'product_type'   => 'Digital',
            'price'          => 299.00,
            'stock_quantity' => 100,
        ])->assertRedirect(route('seller.products.index'));

        // 7. Super Admin can create Listing
        $this->actingAs($admin)->post(route('seller.listings.store'), [
            'business_name' => 'Admin Training Hub',
            'category'      => 'Educational Institute',
        ])->assertRedirect(route('seller.listings.index'));
    }
}
