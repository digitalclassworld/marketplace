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
        $response->assertSee('Order Review');
        $response->assertSee('Have a Coupon Code?');
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
}
