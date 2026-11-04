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
}
