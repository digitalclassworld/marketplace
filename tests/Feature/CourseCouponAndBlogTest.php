<?php

namespace Tests\Feature;

use App\Models\DiscountCoupon;
use App\Models\Post;
use Tests\TestCase;

class CourseCouponAndBlogTest extends TestCase
{
    public function test_course_show_page_renders_with_dynamic_coupons(): void
    {
        // Ensure an active coupon exists
        DiscountCoupon::updateOrCreate(
            ['coupon_code' => 'TESTOFFER15'],
            [
                'seller_id'        => 1,
                'discount_type'    => 'percentage',
                'discount_value'   => 15.00,
                'min_order_amount' => 100.00,
                'valid_from'       => now(),
                'valid_until'      => now()->addYear(),
                'status'           => 'Active',
            ]
        );

        if (!\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            // In sqlite test environment without legacy table, test via standard Course
            $user = \App\Models\User::factory()->create(['role' => 'seller']);
            $seller = \App\Models\Seller::create([
                'user_id' => $user->id,
                'seller_code' => 'SEL' . rand(1000, 9999),
                'account_type' => 'individual',
                'status' => 'approved',
            ]);
            $course = \App\Models\Course::create([
                'seller_id' => $seller->id,
                'title'     => 'Java Program Training Course',
                'slug'      => 'java-program-training-course',
                'category'  => 'Development',
                'price'     => 10000,
                'status'    => 'approved',
            ]);
            $response = $this->get('/course/' . $course->slug);
        } else {
            $response = $this->get('/e-learning/course/2014/java-program-training-course');
        }

        if ($response->status() === 301 || $response->status() === 302) {
            $response = $this->followRedirects($response);
        }

        $response->assertStatus(200);
        $response->assertSee('TESTOFFER15');
        $response->assertSee('15% OFF');
    }

    public function test_public_blog_index_and_show(): void
    {
        $post = Post::where('status', 'Published')->first();
        if (!$post) {
            $post = Post::create([
                'title'            => 'Test Practical Blog Post',
                'slug'             => 'test-practical-blog-post',
                'excerpt'          => 'Summary of practical blog post.',
                'content'          => '<h2>Introduction</h2><p>This is a real life article test.</p>',
                'status'           => 'Published',
                'published_at'     => now(),
                'category'         => 'Technology',
                'author_name'      => 'Admin Author',
                'views'            => 15,
            ]);
        }

        // Test blog index
        $indexResponse = $this->get(route('blog.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($post->title);

        // Test blog show
        $showResponse = $this->get(route('blog.show', $post->slug));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($post->title);
    }

    public function test_admin_cms_routes(): void
    {
        $post = Post::first();
        $this->assertNotNull($post);

        // Authenticate as Admin
        $admin = \App\Models\User::where('role', 'admin')->orWhere('role', 'superadmin')->first();
        if (!$admin) {
            $admin = \App\Models\User::factory()->create([
                'role' => 'admin',
                'email' => 'admin_test_' . rand(1000, 9999) . '@example.com',
            ]);
        }

        $this->actingAs($admin, 'web');

        // CMS Index
        $indexResponse = $this->get(route('admin.cms.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($post->title);

        // CMS Create Form
        $createResponse = $this->get(route('admin.cms.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Create Blog Post');

        // CMS Edit Form
        $editResponse = $this->get(route('admin.cms.edit', $post->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Edit Blog Post');
        $editResponse->assertSee($post->title);
    }
}
