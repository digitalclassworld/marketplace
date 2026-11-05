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

    public function test_services_directory_page_loads_successfully(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Get Expert Services');
        $response->assertSee('Professional Services');
        $response->assertSee('Your Projects');
        $response->assertSee('Our Experts');
        $response->assertSee('Verified Experts');
        $response->assertSee('Quality Work');
        $response->assertSee('Secure Payments');
        $response->assertSee('Website Development');
        $response->assertSee('Mobile App Development');
        $response->assertSee('Top Service Providers');
        $response->assertSee('Tech Solutions');
        $response->assertSee('Post Your Service Requirement');
        $response->assertSee('Why Choose Our Services?');
        $response->assertSee('Professional Website Development for School, Institute &amp; Business', false);
    }

    public function test_services_search_filtering(): void
    {
        $response = $this->get('/services?search=Website');

        $response->assertStatus(200);
        $response->assertSee('Professional Website Development');
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
            'seller_code'         => 'DC-SELL-000001',
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
}
