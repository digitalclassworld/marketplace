<?php

namespace Tests\Feature;

use App\Models\BusinessListing;
use App\Models\DiscountCoupon;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    public function test_app_config_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/app/config');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'app_name',
                    'platform',
                    'current_version',
                    'features',
                ],
            ]);
    }

    public function test_home_feed_endpoint_returns_catalog_data(): void
    {
        $response = $this->getJson('/api/home/feed');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'banners',
                    'featured_courses',
                    'featured_services',
                    'popular_businesses',
                    'featured_products',
                    'stats',
                ],
            ]);
    }

    public function test_courses_endpoint_returns_paginated_list(): void
    {
        $response = $this->getJson('/api/courses');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
                'meta' => ['current_page', 'last_page', 'total'],
            ]);
    }

    public function test_services_endpoint_returns_list(): void
    {
        $response = $this->getJson('/api/services');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
                'meta',
            ]);
    }

    public function test_products_endpoint_returns_list(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
                'meta',
            ]);
    }

    public function test_businesses_endpoint_returns_list(): void
    {
        $response = $this->getJson('/api/businesses');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
                'meta',
            ]);
    }

    public function test_categories_endpoint_returns_list(): void
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }

    public function test_auth_registration_and_login_flow(): void
    {
        $uniqueEmail = 'mobileapp_' . time() . '@example.com';

        // 1. Register
        $regResponse = $this->postJson('/api/auth/register', [
            'name'       => 'Mobile Test User',
            'email'      => $uniqueEmail,
            'phone'      => '9876543210',
            'profession' => 'Software Engineer',
            'city'       => 'Ahmedabad',
            'state'      => 'Gujarat',
            'password'   => 'password123',
        ]);

        $regResponse->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'token',
                'user' => ['id', 'name', 'email', 'profession'],
            ]);

        $token = $regResponse->json('token');

        // 2. Profile using Bearer Token
        $profileResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/profile');

        $profileResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('user.email', $uniqueEmail);

        // 3. Login
        $loginResponse = $this->postJson('/api/auth/login', [
            'email'    => $uniqueEmail,
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'token',
                'user',
            ]);
    }

    public function test_cart_operations(): void
    {
        // 1. Add to cart
        $addResponse = $this->postJson('/api/cart/add', [
            'id'       => 101,
            'type'     => 'Course',
            'title'    => 'Full Stack Web Development',
            'price'    => 2999,
            'quantity' => 1,
        ]);

        $addResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('count', 1);

        // 2. View cart
        $cartResponse = $this->getJson('/api/cart');
        $cartResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('total', 2999);

        // 3. Clear cart
        $clearResponse = $this->postJson('/api/cart/clear');
        $clearResponse->assertStatus(200)
            ->assertJsonPath('count', 0);
    }
}
