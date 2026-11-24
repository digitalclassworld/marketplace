<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_page_loads_successfully(): void
    {
        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Instant Marketplace Checkout');
        $response->assertSee('Customer Information');
        $response->assertSee('Payment Method');
        $response->assertSee('Razorpay Secure Checkout');
        $response->assertSee('Direct Bank Transfer');
        $response->assertSee('Order Review');
        $response->assertSee('Have a Coupon Code?');
        $response->assertSee('WELCOME10');
        $response->assertSee('DIGITAL20');
        $response->assertSee('DIWALI50');
        $response->assertSee('Confirm &amp; Place Order', false);
    }

    public function test_authenticated_customer_checkout_page_prefills_details(): void
    {
        $customer = User::factory()->create([
            'role'  => 'customer',
            'name'  => 'Vaibhavi Shah',
            'email' => 'vaibhavi@gmail.com',
            'phone' => '5874142536',
            'city'  => 'Ahmedabad',
        ]);

        $response = $this->actingAs($customer)->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Vaibhavi Shah');
        $response->assertSee('vaibhavi@gmail.com');
        $response->assertSee('5874142536');
    }

    public function test_guest_can_place_order_from_checkout_page_with_coupon(): void
    {
        $payload = [
            'name'           => 'Vaibhavi Shah',
            'email'          => 'vaibhavi@gmail.com',
            'phone'          => '5874142536',
            'city'           => 'Ahmedabad',
            'address'        => 'Street / Area',
            'payment_method' => 'UPI / QR Code / Net Banking',
            'coupon_code'    => 'WELCOME10',
            'discount'       => 225.00,
            'items'          => [
                [
                    'id'              => 101,
                    'type'            => 'Course',
                    'title'           => '3D Epoxy Design And Flooring',
                    'price'           => 2025.00,
                    'original_price'  => 2250.00,
                    'coupon_code'     => 'WELCOME10',
                    'discount_amount' => 225.00,
                    'quantity'        => 1,
                ]
            ],
        ];

        $response = $this->postJson('/cart/checkout', $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('total_amount', '2,025.00');

        $this->assertDatabaseHas('orders', [
            'customer_name'  => 'Vaibhavi Shah',
            'customer_email' => 'vaibhavi@gmail.com',
            'amount'         => 2025.00,
            'discount'       => 225.00,
        ]);
    }

    public function test_guest_can_add_item_to_cart_and_normalize_params(): void
    {
        // JSON API add to cart with name/image aliases
        $response = $this->postJson('/cart/add', [
            'id'    => '999',
            'type'  => 'Course',
            'name'  => 'Python Full Masterclass',
            'price' => 1999,
            'image' => 'https://example.com/course.jpg',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('count', 1);

        // Standard form submission redirect
        $formResponse = $this->post('/cart/add', [
            'id'    => '1000',
            'type'  => 'Product',
            'name'  => 'Data Science Handbook',
            'price' => 499,
            'image' => 'https://example.com/book.jpg',
        ]);

        $formResponse->assertRedirect(route('checkout'));
    }

    public function test_course_with_mrp_charges_selling_price_not_mrp(): void
    {
        // Course: Selling price = 10,000, MRP = 12,000
        $payload = [
            'name'           => 'Student Learner',
            'email'          => 'student@example.com',
            'phone'          => '9876543210',
            'city'           => 'Ahmedabad',
            'address'        => 'Navrangpura',
            'payment_method' => 'Razorpay / UPI',
            'items'          => [
                [
                    'id'             => 2014,
                    'type'           => 'Course',
                    'title'          => 'Java Program Training Course',
                    'price'          => 10000.00, // Selling price
                    'original_price' => 12000.00, // MRP
                    'quantity'       => 1,
                ]
            ],
        ];

        $response = $this->postJson('/cart/checkout', $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('total_amount', '10,000.00');

        $this->assertDatabaseHas('orders', [
            'customer_email' => 'student@example.com',
            'amount'         => 10000.00,
            'subtotal'       => 10000.00,
        ]);
    }
}

