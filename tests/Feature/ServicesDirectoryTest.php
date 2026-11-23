<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesDirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['role' => 'seller', 'name' => 'Tech Solutions']);
        $seller = Seller::create([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000004',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        \App\Models\SellerBusinessDetail::create([
            'seller_id'     => $seller->id,
            'business_name' => 'Tech Solutions',
            'city'          => 'Ahmedabad',
        ]);

        Service::create([
            'seller_id'        => $seller->id,
            'title'            => 'Website Development for School, Institute & Business',
            'slug'             => 'website-development-for-school-institute-business',
            'category'         => 'Website Development',
            'price'            => 9999,
            'mrp'              => 14999,
            'delivery_days'    => 5,
            'package_name'     => 'Website + Admin Panel',
            'short_description'=> 'Complete Digital Presence For Your Institution',
            'description'      => 'Modern Design and Student Management with On-Time Delivery, Unlimited Revisions, Source Files Included, and 1 Year Free Support.',
            'thumbnail'        => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
            'status'           => 'approved',
        ]);

        Service::create([
            'seller_id'        => $seller->id,
            'title'            => 'Mobile App Development (Android & iOS)',
            'slug'             => 'mobile-app-development-android-ios',
            'category'         => 'Mobile App Development',
            'price'            => 24999,
            'tags'             => ['Flutter', 'React Native'],
            'status'           => 'approved',
        ]);

        Service::create([
            'seller_id'        => $seller->id,
            'title'            => 'Complete Digital Marketing Package',
            'slug'             => 'complete-digital-marketing-package',
            'category'         => 'Digital Marketing',
            'price'            => 9999,
            'status'           => 'approved',
        ]);
    }

    public function test_services_directory_page_loads_successfully(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Get Expert Services');
        $response->assertSee('Website Development');
        $response->assertSee('Mobile App Development');
        $response->assertSee('Top Service Providers');
        $response->assertSee('Post Your Service Requirement');
        $response->assertSee('Website Development for School, Institute &amp; Business', false);
    }

    public function test_services_search_filtering(): void
    {
        $response = $this->get('/services?search=Website');

        $response->assertStatus(200);
        $response->assertSee('Website Development');
    }

    public function test_services_category_filtering(): void
    {
        $response = $this->get('/services?category=Digital%20Marketing');

        $response->assertStatus(200);
        $response->assertSee('Complete Digital Marketing Package');
    }

    public function test_services_custom_db_service_included(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => \App\Services\SellerIdService::generateTempCode(),
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        Service::create([
            'seller_id'         => $seller->id,
            'title'             => 'Enterprise Cloud Migration & DevOps Consulting',
            'slug'              => 'enterprise-cloud-migration-devops',
            'category'          => 'Website Development',
            'short_description' => 'Migrate your school and institute infrastructure to AWS and Cloudflare seamlessly.',
            'tags'              => 'AWS,Cloudflare,DevOps',
            'price'             => 14999,
            'delivery_days'     => 5,
            'status'            => 'approved',
            'approved_at'       => now(),
        ]);

        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Enterprise Cloud Migration &amp; DevOps Consulting', false);
    }

    public function test_service_detail_page_loads_with_exact_screenshot_data(): void
    {
        $response = $this->get('/service/website-development-for-school-institute-business');

        $response->assertStatus(200);
        $response->assertSee('Website Development for School, Institute &amp; Business', false);
        $response->assertSee('Tech Solutions');
        $response->assertSee('Verified Seller');
        $response->assertSee('Complete Digital Presence For Your Institution');
        $response->assertSee('Modern Design');
        $response->assertSee('Student Management');
        $response->assertSee('On-Time Delivery');
        $response->assertSee('Unlimited Revisions');
        $response->assertSee('Source Files Included');
        $response->assertSee('1 Year Free Support');
        $response->assertSee('Website + Admin Panel');
        $response->assertSee('9,999');
        $response->assertSee('About This Service');
        $response->assertSee('Why Choose Our Service?');
        $response->assertSee('Need Something Custom?');
        $response->assertSee('Delivery Time');
    }

    public function test_service_detail_page_loads_for_other_categories(): void
    {
        $response = $this->get('/service/mobile-app-development-android-ios');

        $response->assertStatus(200);
        $response->assertSee('Mobile App Development (Android &amp; iOS)', false);
        $response->assertSee('Tech Solutions');
        $response->assertSee('Flutter');
    }

    public function test_service_booking_and_quote_submission(): void
    {
        $bookResponse = $this->post('/service/website-development-for-school-institute-business/book', [
            'package' => 'standard',
        ]);
        $bookResponse->assertSessionHas('success');

        $quoteResponse = $this->post('/service/website-development-for-school-institute-business/quote', [
            'title'   => 'Custom Coaching Website',
            'details' => 'Need batch timings and online test series',
            'phone'   => '+91 98765 43210',
        ]);
        $quoteResponse->assertSessionHas('success');
    }
}
