<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursesDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_courses_directory_page_loads_successfully(): void
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

        $course = Course::create([
            'seller_id'      => $seller->id,
            'title'          => 'Digital Marketing Complete Course 2026',
            'slug'           => 'digital-marketing-complete-course-2026',
            'category'       => 'Digital Marketing',
            'language'       => 'Hindi',
            'level'          => 'Beginner',
            'price'          => 5999,
            'discount_price' => 2999,
            'status'         => 'approved',
            'approved_at'    => now(),
        ]);

        $response = $this->get('/courses');

        $response->assertStatus(200);
        $response->assertSee('All Courses');
        $response->assertSee('Digital Marketing Complete Course 2026');
        $response->assertSee('Computer &amp; IT', false);
        $response->assertSee('Learning Mode');
        $response->assertSee('Price Range');
    }

    public function test_courses_search_filtering(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000002',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        Course::create([
            'seller_id'      => $seller->id,
            'title'          => 'Python for Beginners',
            'slug'           => 'python-for-beginners',
            'category'       => 'Programming',
            'language'       => 'English',
            'level'          => 'Beginner',
            'price'          => 6999,
            'discount_price' => 3499,
            'status'         => 'approved',
            'approved_at'    => now(),
        ]);

        $response = $this->get('/courses?search=Python');

        $response->assertStatus(200);
        $response->assertSee('Python for Beginners');
    }

    public function test_course_detail_page_loads_by_slug_with_seo_and_curriculum(): void
    {
        $user = User::factory()->create([
            'role' => 'seller',
            'name' => 'Hitesh Mohkar',
        ]);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000003',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        $course = Course::create([
            'seller_id'      => $seller->id,
            'title'          => 'Digital Marketing Complete Course 2026',
            'slug'           => 'digital-marketing-complete-course-2026',
            'category'       => 'Digital Marketing',
            'language'       => 'Hindi/English',
            'level'          => 'Beginner to Advanced',
            'price'          => 5999,
            'discount_price' => 2999,
            'status'         => 'approved',
            'description'    => 'Learn SEO, Social Media, Google Ads, Content Marketing with live projects.',
            'approved_at'    => now(),
        ]);

        $response = $this->get('/course/digital-marketing-complete-course-2026');

        $response->assertStatus(200);
        $response->assertSee('Digital Marketing Complete Course 2026');
        $response->assertSee('Hitesh Mohkar');
        $response->assertSee('2,999');
        $response->assertSee('5,999');
        $response->assertSee('What Will You Learn?');
        $response->assertSee('Curriculum');
        $response->assertSee('About the Instructor');
        $response->assertSee('Student Reviews');
        $response->assertSee('schema.org', false);
        $response->assertSee('og:title', false);
    }

    public function test_course_detail_page_returns_404_for_non_existent_course(): void
    {
        $response = $this->get('/course/non-existent-course-slug-12345');

        $response->assertStatus(404);
    }

    public function test_certificate_page_loads_successfully_with_download_pdf(): void
    {
        $response = $this->get('/certificate');

        $response->assertStatus(200);
        $response->assertSee('CERTIFICATE');
        $response->assertSee('ACHIEVEMENT');
        $response->assertSee('Meshwa Patel');
        $response->assertSee('Full Stack Web Development');
        $response->assertSee('Download PDF');
        $response->assertSee('DC2026-00128');
        $response->assertSee('Rajesh Sharma');
        $response->assertSee('Dr. Neha Mehta');
        $response->assertSee('BrightLearn Institute');
    }

    public function test_course_specific_certificate_loads_with_dynamic_course_title(): void
    {
        $user = User::factory()->create(['role' => 'seller']);
        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => 'DC-SELL-000004',
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => Seller::STATUS_ACTIVE,
            'verification_status' => Seller::VERIFICATION_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        Course::create([
            'seller_id'      => $seller->id,
            'title'          => 'Python for Beginners',
            'slug'           => 'python-for-beginners-cert-test',
            'category'       => 'Programming',
            'language'       => 'English',
            'level'          => 'Beginner',
            'price'          => 6999,
            'discount_price' => 3499,
            'status'         => 'approved',
            'approved_at'    => now(),
        ]);

        $response = $this->get('/course/python-for-beginners-cert-test/certificate?name=Meshwa+Patel');

        $response->assertStatus(200);
        $response->assertSee('Python for Beginners');
        $response->assertSee('Meshwa Patel');
        $response->assertSee('Download PDF');
    }

    public function test_navbar_displays_official_digital_class_logo(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('images/logo.png');
    }

    public function test_products_directory_loads_successfully_with_hero_and_cards(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Everything You Need');
        $response->assertSee('to Learn, Teach &amp; Grow', false);
        $response->assertSee('10,000+ Products');
        $response->assertSee('HP 15s Laptop');
        $response->assertSee('Logitech Wireless Mouse');
        $response->assertSee('Tally Prime with GST');
        $response->assertSee('Deal of the Day');
        $response->assertSee('Top Brands');
        $response->assertSee('Buy in Bulk for Your Institute');
    }

    public function test_products_category_filter(): void
    {
        $response = $this->get('/products?category=Accessories');

        $response->assertStatus(200);
        $response->assertSee('Accessories');
    }
}

