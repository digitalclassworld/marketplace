<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsDirectoryAndShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_directory_page_loads_with_products(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Everything You Need');
        $response->assertSee('HP 15s Laptop');
        $response->assertSee('Logitech Wireless Mouse');
        $response->assertSee('42,999');
        $response->assertSee('Add to Cart');
    }

    public function test_product_detail_page_loads_with_hp_15s_data(): void
    {
        $response = $this->get('/product/hp-15s-laptop');

        $response->assertStatus(200);
        $response->assertSee('HP 15s Laptop');
        $response->assertSee('Intel Core i5 13th Gen');
        $response->assertSee('16GB RAM');
        $response->assertSee('512GB SSD');
        $response->assertSee('42,999');
        $response->assertSee('63,999');
        $response->assertSee('Buy Now');
        $response->assertSee('Add to Cart');
        $response->assertSee('Frequently Bought Together');
        $response->assertSee('Similar Products');
    }

    public function test_product_detail_page_loads_different_product_categories_dynamically(): void
    {
        // 1. Test Logitech Mouse
        $responseMouse = $this->get('/product/logitech-wireless-mouse');
        $responseMouse->assertStatus(200);
        $responseMouse->assertSee('Logitech Wireless Mouse');
        $responseMouse->assertSee('1000 DPI Optical');
        $responseMouse->assertSee('24-Month Battery');
        $responseMouse->assertSee('499');

        // 2. Test Canon Printer
        $responsePrinter = $this->get('/product/canon-g3010-all-in-one-ink-tank-printer');
        $responsePrinter->assertStatus(200);
        $responsePrinter->assertSee('Canon PIXMA G3010');
        $responsePrinter->assertSee('Integrated Ink Tank');
        $responsePrinter->assertSee('12,499');

        // 3. Test Classroom Projector
        $responseProjector = $this->get('/product/classroom-projector');
        $responseProjector->assertStatus(200);
        $responseProjector->assertSee('Epson EB-E01');
        $responseProjector->assertSee('3,600 ANSI Lumens');
        $responseProjector->assertSee('39,999');
    }

    public function test_custom_product_detail_page_loads_from_database(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000002',
            'account_type'        => Seller::ACCOUNT_TYPE_INDIVIDUAL,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        $product = Product::create([
            'seller_id'        => $seller->id,
            'title'            => 'Dell Inspiron 15 3520 Laptop',
            'slug'             => 'dell-inspiron-15-3520-laptop',
            'category'         => 'Laptops & Computers',
            'price'            => 45999,
            'mrp'              => 58999,
            'stock_quantity'   => 20,
            'shipping_details' => 'Intel Core i5, 16GB, 512GB SSD',
            'description'      => 'A reliable laptop for students and everyday business tasks.',
            'thumbnail'        => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&auto=format&fit=crop&q=80',
            'status'           => 'approved',
        ]);

        $response = $this->get('/product/dell-inspiron-15-3520-laptop');

        $response->assertStatus(200);
        $response->assertSee('Dell Inspiron 15 3520 Laptop');
        $response->assertSee('45,999');
        $response->assertSee('58,999');
    }
}
