<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CustomerGoogleAuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('services.google.client_id', 'test-client-id');
        Config::set('services.google.client_secret', 'test-client-secret');
        Config::set('services.google.redirect', 'https://web.digitalclassworld.in/auth/google/callback');
    }

    public function test_redirect_to_google_when_configured(): void
    {
        $response = $this->get(route('auth.google'));

        $response->assertStatus(302);
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('accounts.google.com/o/oauth2/v2/auth', $redirectUrl);
        $this->assertStringContainsString('client_id=test-client-id', $redirectUrl);
        $this->assertStringContainsString('response_type=code', $redirectUrl);
        $this->assertNotNull(session('google_oauth_state'));
    }

    public function test_redirect_to_google_warns_when_not_configured(): void
    {
        Config::set('services.google.client_id', null);

        $response = $this->from(route('customer.login'))->get(route('auth.google'));

        $response->assertRedirect(route('customer.login'));
        $response->assertSessionHas('error');
    }

    public function test_google_callback_creates_and_logs_in_customer(): void
    {
        $state = 'test-oauth-state-123456';

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'mock-google-access-token',
                'expires_in'   => 3600,
            ], 200),
            'https://www.googleapis.com/oauth2/v3/userinfo' => Http::response([
                'sub'     => 'google-unique-id-998877',
                'email'   => 'newstudent@example.com',
                'name'    => 'Student Learner',
                'picture' => 'https://example.com/avatar.jpg',
            ], 200),
        ]);

        $response = $this->withSession(['google_oauth_state' => $state])
            ->get(route('auth.google.callback', [
                'code'  => 'mock-google-code',
                'state' => $state,
            ]));

        $response->assertRedirect(route('home'));
        $this->assertTrue(Auth::guard('web')->check());

        $user = Auth::guard('web')->user();
        $this->assertEquals('newstudent@example.com', $user->email);
        $this->assertEquals('customer', $user->role);
        $this->assertTrue($user->isCustomer());
        $this->assertFalse($user->isSeller());
        $this->assertEquals('google-unique-id-998877', $user->google_id);

        // Clean up
        $user->delete();
    }

    public function test_google_callback_blocks_seller_account(): void
    {
        $state = 'test-oauth-state-seller';

        // Create a seller
        $seller = User::factory()->create([
            'email' => 'seller-google-test@example.com',
            'role'  => 'seller',
        ]);

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'mock-google-access-token',
                'expires_in'   => 3600,
            ], 200),
            'https://www.googleapis.com/oauth2/v3/userinfo' => Http::response([
                'sub'     => 'google-seller-sub-123',
                'email'   => 'seller-google-test@example.com',
                'name'    => 'Existing Seller',
            ], 200),
        ]);

        $response = $this->withSession(['google_oauth_state' => $state])
            ->get(route('auth.google.callback', [
                'code'  => 'mock-google-code',
                'state' => $state,
            ]));

        $response->assertRedirect(route('customer.login'));
        $response->assertSessionHas('error');
        $this->assertFalse(Auth::guard('web')->check());

        // Clean up
        $seller->delete();
    }
}
