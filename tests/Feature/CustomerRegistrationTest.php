<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_dedicated_registration_page(): void
    {
        $response = $this->get(route('customer.register'));
        $response->assertStatus(200);
        $response->assertSee('Create Customer Account');
        $response->assertSee('name="profession"', false);
        $response->assertSee('Student / Learner');
        $response->assertSee('Business Owner');
        $response->assertSee('Working Professional / Employee');
        $response->assertSee('Teacher / Educator');
        $response->assertSee('No Approval Needed');
    }

    public function test_new_customer_can_register_with_profession_and_is_immediately_active(): void
    {
        $response = $this->post(route('customer.register.submit'), [
            'name'                  => 'Rohan Mehta',
            'email'                 => 'rohan.business@example.com',
            'phone'                 => '9876543210',
            'profession'            => 'Business Owner',
            'city'                  => 'Ahmedabad',
            'state'                 => 'Gujarat',
            'interests'             => ['Courses', 'Services'],
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name'       => 'Rohan Mehta',
            'email'      => 'rohan.business@example.com',
            'role'       => 'customer',
            'profession' => 'Business Owner',
            'city'       => 'Ahmedabad',
            'state'      => 'Gujarat',
        ]);

        $user = User::where('email', 'rohan.business@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
        $this->assertTrue(Auth::user()->isCustomer());

        // Can immediately browse marketplace and buy with active account
        $homeRes = $this->get(route('home'));
        $homeRes->assertStatus(200);
        $homeRes->assertSee('Rohan Mehta');
    }

    public function test_customer_registration_requires_profession_dropdown(): void
    {
        $response = $this->post(route('customer.register.submit'), [
            'name'                  => 'Ananya Patel',
            'email'                 => 'ananya@example.com',
            'phone'                 => '9876543211',
            'profession'            => '', // Empty
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('profession');
        $this->assertDatabaseMissing('users', [
            'email' => 'ananya@example.com',
        ]);
    }

    public function test_registered_customer_appears_as_active_in_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => 'superadmin']);

        $customer = User::create([
            'name'              => 'Kavita Sharma',
            'email'             => 'kavita.teacher@example.com',
            'phone'             => '9988776655',
            'profession'        => 'Teacher / Educator',
            'city'              => 'Surat',
            'state'             => 'Gujarat',
            'role'              => 'customer',
            'password'          => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertSee('Kavita Sharma');
        $response->assertSee('Teacher / Educator');
        $response->assertSee('Active');
    }
}
