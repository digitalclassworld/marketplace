<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageCategoriesTest extends TestCase
{
    public function test_home_page_renders_with_mockup_category_logos()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('home-categories-section');
        $response->assertSee('home-categories-grid');
        $response->assertSee('Online Courses');
        $response->assertSee('Professional Services');
        $response->assertSee('Products');
        $response->assertSee('Businesses');
        $response->assertSee('Digital Marketing');
        $response->assertSee('IT & Software');
        $response->assertSee('Design & Creative');
        $response->assertSee('Tally & Accounting');
        $response->assertSee('Coaching Institutes');
        $response->assertSee('Health & Wellness');
        $response->assertSee('More');
    }
}
