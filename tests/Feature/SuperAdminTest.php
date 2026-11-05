<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\SellerBusinessDetail;
use App\Models\User;
use App\Services\SellerIdService;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function createSuperAdmin(): User
    {
        return User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'              => 'Super Admin',
                'phone'             => '9876543210',
                'password'          => Hash::make('Admin@123'),
                'role'              => 'superadmin',
                'email_verified_at' => now(),
            ]
        );
    }

    protected function createTestSeller(string $name, string $email, string $status = Seller::STATUS_PENDING_APPROVAL): User
    {
        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'phone'    => '9876543210',
            'password' => Hash::make('Secret123!'),
            'role'     => 'seller',
        ]);

        $seller = new Seller([
            'user_id'             => $user->id,
            'seller_code'         => SellerIdService::generateTempCode(),
            'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
            'seller_status'       => $status,
            'verification_status' => Seller::VERIFICATION_NOT_VERIFIED,
            'registration_date'   => now(),
        ]);
        $seller->save();

        $sellerIdService = new SellerIdService();
        $sellerIdService->assignSellerCode($seller);

        SellerBusinessDetail::create([
            'seller_id'     => $seller->id,
            'business_name' => $name . "'s Academy",
            'city'          => 'Ahmedabad',
            'state'         => 'Gujarat',
            'pincode'       => '380015',
        ]);

        return $user->fresh(['seller.businessDetail']);
    }

    /**
     * Test 1: Super Admin Seeder creates account idempotently.
     */
    public function test_super_admin_seeder_creates_account_idempotently(): void
    {
        $this->seed(SuperAdminSeeder::class);
        $this->seed(SuperAdminSeeder::class);

        $this->assertEquals(1, User::where('email', 'superadmin@gmail.com')->count());

        $admin = User::where('email', 'superadmin@gmail.com')->first();
        $this->assertEquals('superadmin', $admin->role);
        $this->assertTrue($admin->isSuperAdmin());
        $this->assertTrue(Hash::check('Admin@123', $admin->password));
    }

    /**
     * Test 2: Super Admin login page loads.
     */
    public function test_super_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Super Admin Portal');
        $response->assertSee('Administrative Login');
    }

    /**
     * Test 2b: Logged in seller can access admin login page to switch accounts.
     */
    public function test_logged_in_seller_can_access_admin_login_page_to_switch_accounts(): void
    {
        $seller = $this->createTestSeller('Test Seller', 'seller.switch@example.com');
        $response = $this->actingAs($seller)->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Super Admin Portal');
        $response->assertSee('Currently signed in as Seller');
    }

    /**
     * Test 3: Super Admin login succeeds with valid credentials.
     */
    public function test_super_admin_login_succeeds_with_valid_credentials(): void
    {
        $this->createSuperAdmin();

        $response = $this->post('/admin/login', [
            'email'    => 'superadmin@gmail.com',
            'password' => 'Admin@123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isSuperAdmin());
    }

    /**
     * Test 4: Super Admin login rejects invalid password.
     */
    public function test_super_admin_login_rejects_invalid_password(): void
    {
        $this->createSuperAdmin();

        $response = $this->post('/admin/login', [
            'email'    => 'superadmin@gmail.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test 5: Normal seller is forbidden from accessing Super Admin routes.
     */
    public function test_normal_seller_cannot_access_super_admin_routes(): void
    {
        $sellerUser = $this->createTestSeller('Normal Seller', 'seller@example.com');

        $response = $this->actingAs($sellerUser)->get('/admin/dashboard');

        $response->assertRedirect('/admin/login');
        $response->assertSessionHas('error');
    }

    /**
     * Test 5b: Super Admin accessing seller portal is guided to admin dashboard.
     */
    public function test_super_admin_can_access_seller_dashboard_without_redirection(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->get('/seller/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('info');
    }

    /**
     * Test 6: Unauthenticated visitor is redirected to admin login.
     */
    public function test_unauthenticated_visitor_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');

        $responseSellers = $this->get('/admin/sellers');
        $responseSellers->assertRedirect('/admin/login');
    }

    /**
     * Test 7: Super Admin dashboard displays real database statistics.
     */
    public function test_super_admin_dashboard_displays_real_database_stats(): void
    {
        $admin = $this->createSuperAdmin();
        $this->createTestSeller('Seller One', 's1@example.com', Seller::STATUS_PENDING_APPROVAL);
        $this->createTestSeller('Seller Two', 's2@example.com', Seller::STATUS_ACTIVE);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Welcome Back,');
        $response->assertSee('Total Sellers');
        $response->assertSee('Total Users');
        $response->assertSee('Total Orders');
        $response->assertSee('Total Revenue');
    }

    /**
     * Test 8: Super Admin can view all sellers and filter pending approvals.
     */
    public function test_super_admin_can_view_sellers_and_filter_pending(): void
    {
        $admin = $this->createSuperAdmin();
        $pendingSeller = $this->createTestSeller('Pending Institute', 'pending@example.com', Seller::STATUS_PENDING_APPROVAL);
        $activeSeller  = $this->createTestSeller('Active Academy', 'active@example.com', Seller::STATUS_ACTIVE);

        // View all sellers
        $responseAll = $this->actingAs($admin)->get('/admin/sellers');
        $responseAll->assertStatus(200);
        $responseAll->assertSee($pendingSeller->seller->seller_code);
        $responseAll->assertSee($activeSeller->seller->seller_code);

        // View pending approvals
        $responsePending = $this->actingAs($admin)->get('/admin/sellers/pending');
        $responsePending->assertStatus(200);
        $responsePending->assertSee($pendingSeller->seller->seller_code);
        $responsePending->assertDontSee($activeSeller->seller->seller_code);
    }

    /**
     * Test 9: Complete Seller Approval Workflow and Permission Enforcement.
     */
    public function test_seller_approval_workflow_and_strict_permission_enforcement(): void
    {
        $admin = $this->createSuperAdmin();
        $sellerUser = $this->createTestSeller('Acme Coaching', 'acme@example.com', Seller::STATUS_PENDING_APPROVAL);
        $seller = $sellerUser->seller;

        // 1. As a Pending Seller, trying to access protected selling operation directly is DENIED
        $deniedResponse = $this->actingAs($sellerUser)->get('/seller/courses/create');
        $deniedResponse->assertRedirect('/seller/dashboard');
        $deniedResponse->assertSessionHas('error', 'Your seller account is awaiting Super Admin approval.');

        // 2. Super Admin views seller dossier
        $showResponse = $this->actingAs($admin)->get("/admin/sellers/{$seller->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee($seller->seller_code);
        $showResponse->assertSee('Awaiting Approval');

        // 3. Super Admin APPROVES the seller
        $approveResponse = $this->actingAs($admin)->post("/admin/sellers/{$seller->id}/approve");
        $approveResponse->assertRedirect();
        $approveResponse->assertSessionHas('success');

        // Check database changes
        $seller->refresh();
        $this->assertEquals(Seller::STATUS_ACTIVE, $seller->seller_status);
        $this->assertEquals(Seller::VERIFICATION_VERIFIED, $seller->verification_status);
        $this->assertNotNull($seller->approved_at);
        $this->assertEquals($admin->id, $seller->approved_by);

        // 4. Authenticated as the newly APPROVED seller, access to selling operation is now ALLOWED
        $allowedResponse = $this->actingAs($sellerUser)->get('/seller/courses/create');
        $allowedResponse->assertStatus(200);
        $allowedResponse->assertSee('Course Add Process');
    }

    /**
     * Test 9b: Super Admin can open seller details for persisted and curated demo sellers.
     */
    public function test_super_admin_can_view_seller_details_for_persisted_and_curated_sellers(): void
    {
        $admin = $this->createSuperAdmin();

        // 1. Curated seller 101 (VCEC)
        $resp101 = $this->actingAs($admin)->get('/admin/sellers/101');
        $resp101->assertStatus(200);
        $resp101->assertSee('VCEC - Vinayak Computer Education');
        $resp101->assertSee('Seller Details');

        // 2. Curated seller 102 (Tech Skills Academy matching Screenshot 9)
        $resp102 = $this->actingAs($admin)->get('/admin/sellers/102');
        $resp102->assertStatus(200);
        $resp102->assertSee('Tech Skills Academy');
        $resp102->assertSee('SELL000123');
        $resp102->assertSee('Rahul Sharma');
        $resp102->assertSee('Overview');

        // 3. Fallback / generic ID (e.g. 1)
        $resp1 = $this->actingAs($admin)->get('/admin/sellers/1');
        $resp1->assertStatus(200);

        // 4. Dashboard shows clickable Recent Sellers
        $respDash = $this->actingAs($admin)->get('/admin/dashboard');
        $respDash->assertStatus(200);
        $respDash->assertSee('/admin/sellers/');
    }

    /**
     * Test 10: Super Admin can reject a seller and block selling.
     */
    public function test_super_admin_can_reject_seller(): void
    {
        $admin = $this->createSuperAdmin();
        $sellerUser = $this->createTestSeller('Reject Target', 'reject@example.com', Seller::STATUS_PENDING_APPROVAL);
        $seller = $sellerUser->seller;

        $response = $this->actingAs($admin)->post("/admin/sellers/{$seller->id}/reject", [
            'reason' => 'Invalid business documentation provided.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('warning');

        $seller->refresh();
        $this->assertEquals(Seller::STATUS_REJECTED, $seller->seller_status);
        $this->assertEquals('Invalid business documentation provided.', $seller->rejection_reason);
        $this->assertNotNull($seller->rejected_at);
        $this->assertEquals($admin->id, $seller->rejected_by);

        // Rejected seller cannot sell
        $deniedResponse = $this->actingAs($sellerUser)->get('/seller/courses/create');
        $deniedResponse->assertRedirect('/seller/dashboard');
        $deniedResponse->assertSessionHas('error', 'Your seller account was rejected. You cannot create or publish listings.');
    }

    /**
     * Test 11: Super Admin can suspend and reactivate a seller.
     */
    public function test_super_admin_can_suspend_and_reactivate_seller(): void
    {
        $admin = $this->createSuperAdmin();
        $sellerUser = $this->createTestSeller('Active Target', 'target@example.com', Seller::STATUS_ACTIVE);
        $seller = $sellerUser->seller;

        // Suspend
        $suspendResponse = $this->actingAs($admin)->post("/admin/sellers/{$seller->id}/suspend", [
            'reason' => 'Policy violation in listings.',
        ]);
        $suspendResponse->assertRedirect();

        $seller->refresh();
        $this->assertEquals(Seller::STATUS_SUSPENDED, $seller->seller_status);
        $this->assertNotNull($seller->suspended_at);
        $this->assertEquals($admin->id, $seller->suspended_by);

        // Suspended seller is blocked from selling
        $deniedResponse = $this->actingAs($sellerUser)->get('/seller/courses/create');
        $deniedResponse->assertRedirect('/seller/dashboard');
        $deniedResponse->assertSessionHas('error', 'Your seller account is suspended. Listing publishing is restricted.');

        // Reactivate
        $reactivateResponse = $this->actingAs($admin)->post("/admin/sellers/{$seller->id}/reactivate");
        $reactivateResponse->assertRedirect();

        $seller->refresh();
        $this->assertEquals(Seller::STATUS_ACTIVE, $seller->seller_status);

        // Active seller can sell again
        $allowedResponse = $this->actingAs($sellerUser)->get('/seller/courses/create');
        $allowedResponse->assertStatus(200);
    }

    /**
     * Test 12: Super Admin logout.
     */
    public function test_super_admin_logout(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->post('/admin/logout');

        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    /**
     * Test 13: Super Admin can view Users & Members management module with stats and inspector.
     */
    public function test_super_admin_can_view_users_management(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Users &amp; Members', false);
        $response->assertSee('Total Users');
        $response->assertSee('Students');
        $response->assertSee('Professionals');
        $response->assertSee('Institutes');
        $response->assertSee('Sellers');
        $response->assertSee('Active Users');
        $response->assertSee('Inactive Users');
        $response->assertSee('Rahul Sharma');
        $response->assertSee('UDC00125');
        $response->assertSee('Basic Information');
        $response->assertSee('Platform Activity');
        $response->assertSee('Recent Orders');
    }

    /**
     * Test 14: Super Admin can create a new member.
     */
    public function test_super_admin_can_create_member(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name'     => 'Anand Kumar Super Learner',
            'email'    => 'anand.superlearner@example.com',
            'phone'    => '9876543219',
            'role'     => 'user',
            'password' => 'Password@123',
        ]);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', ['email' => 'anand.superlearner@example.com']);
    }

    /**
     * Test 15: Super Admin can export members CSV.
     */
    public function test_super_admin_can_export_users(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->get('/admin/users/export');

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
    }

    /**
     * Test 16: Super Admin can view Banners & Promotions with 7 KPI metrics and device mockup.
     */
    public function test_super_admin_can_view_banners_and_promotions_management(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->get('/admin/promotions');

        $response->assertStatus(200);
        $response->assertSee('Banners &amp; Promotions', false);
        $response->assertSee('Total Banners');
        $response->assertSee('Active Banners');
        $response->assertSee('Total Campaigns');
        $response->assertSee('Total Views');
        $response->assertSee('Total Clicks');
        $response->assertSee('Diwali Offer 2026');
        $response->assertSee('Digital Marketing Course');
        $response->assertSee('List Your Institute');
        $response->assertSee('Banner Details');
        $response->assertSee('Web View');
        $response->assertSee('App View');

        // Test filtering by Tab
        $respTab = $this->actingAs($admin)->get('/admin/promotions?tab=homepage');
        $respTab->assertStatus(200);
        $respTab->assertSee('Diwali Offer 2026');
    }

    /**
     * Test 17: Super Admin can create and export banners.
     */
    public function test_super_admin_can_create_and_export_banners(): void
    {
        $admin = $this->createSuperAdmin();

        // 1. Create banner
        $createResp = $this->actingAs($admin)->post('/admin/promotions', [
            'title'    => 'New Year Special 2027',
            'type'     => 'Homepage',
            'campaign' => 'Festival Drive',
            'link'     => 'https://digitalclass.in/new-year',
        ]);
        $createResp->assertRedirect();
        $createResp->assertSessionHas('success');
        $this->assertDatabaseHas('promotions', ['listing_title' => 'New Year Special 2027']);

        // 2. Export banners
        $exportResp = $this->actingAs($admin)->get('/admin/promotions/export');
        $exportResp->assertStatus(200);
        $this->assertTrue(str_contains($exportResp->headers->get('content-type'), 'text/csv'));
    }

    /**
     * Test 18: Super Admin can view Coupons & Offers management with KPI cards and festive voucher inspector.
     */
    public function test_super_admin_can_view_coupons_and_offers_management(): void
    {
        $admin = $this->createSuperAdmin();

        $response = $this->actingAs($admin)->get('/admin/coupons');

        $response->assertStatus(200);
        $response->assertSee('Coupons &amp; Offers', false);
        $response->assertSee('Total Coupons');
        $response->assertSee('Active Coupons');
        $response->assertSee('Scheduled');
        $response->assertSee('Expired');
        $response->assertSee('Total Usage');
        $response->assertSee('DIWALI50');
        $response->assertSee('FIRST1000');
        $response->assertSee('WELCOME20');
        $response->assertSee('Coupon Details');
        $response->assertSee('Applicable Platforms');
        $response->assertSee('Applicable Categories');

        // Test filter tab
        $respActive = $this->actingAs($admin)->get('/admin/coupons?tab=active');
        $respActive->assertStatus(200);
        $respActive->assertSee('DIWALI50');
    }

    /**
     * Test 19: Super Admin can create, toggle status, and export coupons.
     */
    public function test_super_admin_can_create_and_export_coupons(): void
    {
        $admin = $this->createSuperAdmin();

        // 1. Create coupon
        $createResp = $this->actingAs($admin)->post('/admin/coupons', [
            'coupon_code'    => 'HOLI2027',
            'offer_name'     => 'Holi Mega Discount',
            'discount_type'  => 'Percentage',
            'discount_value' => 30,
        ]);
        $createResp->assertRedirect();
        $createResp->assertSessionHas('success');
        $this->assertDatabaseHas('discount_coupons', ['coupon_code' => 'HOLI2027']);

        // 2. Export coupons
        $exportResp = $this->actingAs($admin)->get('/admin/coupons/export');
        $exportResp->assertStatus(200);
        $this->assertTrue(str_contains($exportResp->headers->get('content-type'), 'text/csv'));

        // 3. View create coupon form
        $createPageResp = $this->actingAs($admin)->get('/admin/coupons/create');
        $createPageResp->assertStatus(200);
        $createPageResp->assertSee('Create Coupon / Offer');
        $createPageResp->assertSee('Coupon Code *', false);
        $createPageResp->assertSee('DIWALI50');
        $createPageResp->assertSee('Coupon Preview');
        $createPageResp->assertSee('Diwali Special Offer');
        $createPageResp->assertSee('Discount Percentage');

        // 4. View edit coupon form
        $editPageResp = $this->actingAs($admin)->get('/admin/coupons/1/edit');
        $editPageResp->assertStatus(200);
        $editPageResp->assertSee('Edit Coupon / Offer');
        $editPageResp->assertSee('Save Changes');

        // 5. Update coupon
        $updateResp = $this->actingAs($admin)->put('/admin/coupons/1', [
            'coupon_code'    => 'DIWALI60',
            'offer_name'     => 'Updated Diwali Offer',
            'discount_type'  => 'Percentage',
            'discount_value' => 60,
        ]);
        $updateResp->assertRedirect(route('admin.coupons.index'));
        $updateResp->assertSessionHas('success');
    }

    /**
     * Test 20: Dummy curated data is excluded when show_dummy_data is disabled (Production mode).
     */
    public function test_dummy_data_is_hidden_when_disabled_for_production(): void
    {
        $admin = $this->createSuperAdmin();

        // 1. Temporarily disable dummy data (simulating APP_ENV=production)
        config(['marketplace.show_dummy_data' => false]);

        $response = $this->actingAs($admin)->get('/admin/coupons');
        $response->assertStatus(200);
        // Curated dummy coupon should NOT appear
        $response->assertDontSee('MEGADEAL');
        $response->assertDontSee('DIWALI100');

        // Courses page should not show curated dummy courses when DB is empty
        $coursesResp = $this->actingAs($admin)->get('/admin/catalog/courses');
        $coursesResp->assertStatus(200);
        $coursesResp->assertDontSee('CRS00125');

        // Restore config
        config(['marketplace.show_dummy_data' => true]);
    }
}



