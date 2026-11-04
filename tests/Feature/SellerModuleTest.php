<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\SellerBusinessDetail;
use App\Models\User;
use App\Services\SellerIdService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SellerModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper to create a test seller in the database.
     */
    protected function createTestSeller(array $attributes = []): User
    {
        $user = User::create([
            'name'     => $attributes['name'] ?? 'Rahul Sharma',
            'email'    => $attributes['email'] ?? 'rahul.test@example.com',
            'phone'    => $attributes['phone'] ?? '9876543210',
            'password' => Hash::make($attributes['password'] ?? 'Secret123!'),
            'role'     => 'seller',
        ]);

        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => SellerIdService::generateTempCode(),
            'account_type'        => $attributes['account_type'] ?? Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => $attributes['seller_status'] ?? Seller::STATUS_PENDING_APPROVAL,
            'verification_status' => $attributes['verification_status'] ?? Seller::VERIFICATION_NOT_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        $sellerIdService = new SellerIdService();
        $sellerIdService->assignSellerCode($seller);

        SellerBusinessDetail::create([
            'seller_id'     => $seller->id,
            'business_name' => $attributes['business_name'] ?? "Rahul's Learning Academy",
            'city'          => $attributes['city'] ?? 'Ahmedabad',
            'state'         => $attributes['state'] ?? 'Gujarat',
            'pincode'       => $attributes['pincode'] ?? '380015',
        ]);

        return $user->fresh(['seller.businessDetail']);
    }

    /**
     * Test 1: Homepage opens at root URL and renders Digital Class Marketplace hero & nav.
     */
    public function test_homepage_loads_successfully_with_correct_elements(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Digital');
        $response->assertSee('Class');
        $response->assertSee('Learn. Hire. Buy. Discover.');
        $response->assertSee('Become a Seller');
        $response->assertSee('Seller Login');
        $response->assertSee('Online Courses');
        $response->assertSee('Professional Services');
        $response->assertSee('Coming Soon');
    }

    /**
     * Test 2: Seller registration page opens.
     */
    public function test_seller_registration_page_loads(): void
    {
        $response = $this->get('/seller/register');

        $response->assertStatus(200);
        $response->assertSee('Create Your Seller Account');
        $response->assertSee('Basic Details');
        $response->assertSee('Business Info');
        $response->assertSee('Verify');
        $response->assertSee('Go Live');
    }

    /**
     * Test 3: Seller registration fails on validation errors.
     */
    public function test_seller_registration_validation_fails_for_empty_fields(): void
    {
        $response = $this->post('/seller/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'password', 'account_type']);
    }

    /**
     * Test 4: Full Seller Registration, DB transactions, and automatic Seller ID generation.
     */
    public function test_seller_registration_creates_records_and_generates_unique_seller_id(): void
    {
        $payload = [
            'name'                  => 'Rahul Sharma',
            'email'                 => 'rahul.reg@example.com',
            'phone'                 => '9876543210',
            'password'              => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'account_type'          => Seller::ACCOUNT_TYPE_INSTITUTE,
            'business_name'         => "Rahul's Learning Hub",
            'business_email'        => 'academy@rahul.com',
            'business_phone'        => '9876543210',
            'business_category'     => 'Education & Training',
            'business_description'  => 'Computer science and web development training.',
            'website'               => 'https://rahulacademy.com',
            'address'               => '101, Tech Park',
            'city'                  => 'Ahmedabad',
            'state'                 => 'Gujarat',
            'pincode'               => '380015',
        ];

        $response = $this->post('/seller/register', $payload);

        $response->assertRedirect('/seller/register/success');

        // Verify User record
        $user = User::where('email', 'rahul.reg@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Rahul Sharma', $user->name);
        $this->assertEquals('seller', $user->role);
        $this->assertTrue(Hash::check('Secret123!', $user->password));

        // Verify Seller record
        $seller = $user->seller;
        $this->assertNotNull($seller);
        $this->assertMatchesRegularExpression('/^DC-SELL-\d{6}$/', $seller->seller_code);
        $this->assertEquals(Seller::STATUS_PENDING_APPROVAL, $seller->seller_status);
        $this->assertEquals(Seller::VERIFICATION_NOT_VERIFIED, $seller->verification_status);
        $this->assertEquals(Seller::ACCOUNT_TYPE_INSTITUTE, $seller->account_type);

        // Verify Business Detail record
        $business = $seller->businessDetail;
        $this->assertNotNull($business);
        $this->assertEquals("Rahul's Learning Hub", $business->business_name);
        $this->assertEquals('Ahmedabad', $business->city);
        $this->assertEquals('380015', $business->pincode);

        // Verify user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test 5: Seller ID sequence and uniqueness across multiple registrations.
     */
    public function test_multiple_registrations_receive_sequential_unique_seller_ids(): void
    {
        $payload1 = [
            'name'                  => 'Priya Patel',
            'email'                 => 'priya.seq@example.com',
            'phone'                 => '9876500001',
            'password'              => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'account_type'          => Seller::ACCOUNT_TYPE_INDIVIDUAL,
        ];
        $this->post('/seller/register', $payload1);

        $seller1 = User::where('email', 'priya.seq@example.com')->first()->seller;

        $payload2 = [
            'name'                  => 'Amit Kumar',
            'email'                 => 'amit.seq@example.com',
            'phone'                 => '9876500002',
            'password'              => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'account_type'          => Seller::ACCOUNT_TYPE_AGENCY,
        ];
        $this->post('/seller/register', $payload2);

        $seller2 = User::where('email', 'amit.seq@example.com')->first()->seller;

        $this->assertNotEquals($seller1->seller_code, $seller2->seller_code);
        $this->assertEquals(SellerIdService::format($seller1->id), $seller1->seller_code);
        $this->assertEquals(SellerIdService::format($seller2->id), $seller2->seller_code);
    }

    /**
     * Test 6: Duplicate email is rejected during registration.
     */
    public function test_duplicate_email_registration_is_rejected(): void
    {
        $this->createTestSeller(['email' => 'duplicate@example.com']);

        $response = $this->post('/seller/register', [
            'name'                  => 'New Clone',
            'email'                 => 'duplicate@example.com',
            'phone'                 => '9123456789',
            'password'              => 'Secret123!',
            'password_confirmation' => 'Secret123!',
            'account_type'          => Seller::ACCOUNT_TYPE_INDIVIDUAL,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test 7: Unauthenticated visitor cannot access protected seller routes.
     */
    public function test_unauthenticated_visitor_redirected_to_seller_login(): void
    {
        $response = $this->get('/seller/dashboard');
        $response->assertRedirect('/seller/login');

        $responseProfile = $this->get('/seller/profile');
        $responseProfile->assertRedirect('/seller/login');
    }

    /**
     * Test 8: Seller login works with valid credentials and rejects invalid credentials.
     */
    public function test_seller_login_validation_and_authentication(): void
    {
        $user = $this->createTestSeller([
            'email'    => 'seller.login@example.com',
            'password' => 'ValidPassword123!',
        ]);

        // 1. Invalid password test
        $responseInvalid = $this->post('/seller/login', [
            'email'    => 'seller.login@example.com',
            'password' => 'WrongPassword!',
        ]);
        $responseInvalid->assertSessionHasErrors(['email']);
        $this->assertGuest();

        // 2. Valid password test
        $responseValid = $this->post('/seller/login', [
            'email'    => 'seller.login@example.com',
            'password' => 'ValidPassword123!',
        ]);
        $responseValid->assertRedirect('/seller/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test 9: Protected Seller Dashboard loads with correct Seller ID and dynamic status states.
     */
    public function test_seller_dashboard_displays_seller_id_and_status(): void
    {
        $user = $this->createTestSeller([
            'name'          => 'Rahul Sharma',
            'email'         => 'rahul.dash@example.com',
            'seller_status' => Seller::STATUS_PENDING_APPROVAL,
        ]);

        // 1. Pending Approval displays "Under Process"
        $responsePending = $this->actingAs($user)->get('/seller/dashboard');
        $responsePending->assertStatus(200);
        $responsePending->assertSee($user->seller->seller_code);
        $responsePending->assertSee('Under Process');

        // 2. Active displays Working Dashboard with stats and listings
        $user->seller->update(['seller_status' => Seller::STATUS_ACTIVE]);
        $responseActive = $this->actingAs($user)->get('/seller/dashboard');
        $responseActive->assertStatus(200);
        $responseActive->assertSee('Total Orders');
        $responseActive->assertSee('Total Earnings');
        $responseActive->assertSee('Manage Your Listings');

        // 3. Rejected displays "Sorry! Your Application was Not Approved"
        $user->seller->update([
            'seller_status' => Seller::STATUS_REJECTED,
            'rejection_reason' => 'Missing educational certificates.',
        ]);
        $responseRejected = $this->actingAs($user)->get('/seller/dashboard');
        $responseRejected->assertStatus(200);
        $responseRejected->assertSee('Sorry! Your Application was Not Approved');
        $responseRejected->assertSee('Missing educational certificates.');
    }

    /**
     * Test 10: Seller Profile page loads and permits updating allowed details while locking Seller ID.
     */
    public function test_seller_profile_update_maintains_security_restrictions(): void
    {
        $user = $this->createTestSeller([
            'name'  => 'Rahul Sharma',
            'email' => 'rahul.profile@example.com',
            'phone' => '9876543210',
        ]);
        $originalSellerCode = $user->seller->seller_code;

        $response = $this->actingAs($user)->get('/seller/profile');
        $response->assertStatus(200);
        $response->assertSee($originalSellerCode);

        // Attempt updating permitted info along with forbidden fields (seller_code, seller_status)
        $updatePayload = [
            'name'                 => 'Rahul S. Updated',
            'email'                => 'rahul.updated@example.com',
            'phone'                => '9876599999',
            'business_name'        => 'Rahul International Academy',
            'business_email'       => 'new@rahulacademy.com',
            'business_phone'       => '9876599999',
            'city'                 => 'Gandhinagar',
            'state'                => 'Gujarat',
            'pincode'              => '382010',
            'seller_code'          => 'DC-SELL-HACKED',
            'seller_status'        => 'Active',
            'verification_status'  => 'Verified',
        ];

        $putResponse = $this->actingAs($user)->put('/seller/profile', $updatePayload);
        $putResponse->assertRedirect('/seller/profile');

        // Reload from database
        $user->refresh();
        $seller = $user->seller->fresh();
        $business = $seller->businessDetail->fresh();

        // Permitted fields updated
        $this->assertEquals('Rahul S. Updated', $user->name);
        $this->assertEquals('rahul.updated@example.com', $user->email);
        $this->assertEquals('9876599999', $user->phone);
        $this->assertEquals('Rahul International Academy', $business->business_name);
        $this->assertEquals('Gandhinagar', $business->city);

        // Security restrictions maintained: Seller ID and statuses remain untouched!
        $this->assertEquals($originalSellerCode, $seller->seller_code);
        $this->assertEquals(Seller::STATUS_PENDING_APPROVAL, $seller->seller_status);
        $this->assertEquals(Seller::VERIFICATION_NOT_VERIFIED, $seller->verification_status);
    }

    /**
     * Test 11: Seller logout safely ends the session and redirects to home.
     */
    public function test_seller_logout_terminates_session(): void
    {
        $user = $this->createTestSeller([
            'email' => 'logout.test@example.com',
        ]);

        $response = $this->actingAs($user)->post('/seller/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
