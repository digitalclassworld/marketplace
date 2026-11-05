<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCatalogController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminSellerController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\SellerRegistrationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\SellerBusinessListingController;
use App\Http\Controllers\Seller\SellerCourseController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerMessageController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerProfileController;
use App\Http\Controllers\Seller\SellerPromotionController;
use App\Http\Controllers\Seller\SellerServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Public Marketplace Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/service/{slug}', [HomeController::class, 'serviceShow'])->name('service.show');
Route::post('/service/{slug}/book', [HomeController::class, 'serviceBook'])->name('service.book');
Route::post('/service/{slug}/quote', [HomeController::class, 'serviceQuote'])->name('service.quote');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}', [HomeController::class, 'productShow'])->name('product.show');
Route::get('/course/{slug}', [HomeController::class, 'courseShow'])->name('course.show');
Route::post('/course/{slug}/enroll', [HomeController::class, 'courseEnroll'])->name('course.enroll');
Route::post('/course/{slug}/review', [HomeController::class, 'courseReview'])->name('course.review');
Route::get('/course/{slug}/certificate', [CertificateController::class, 'forCourse'])->name('course.certificate');
Route::get('/certificate/{code?}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/business/{slug?}', [HomeController::class, 'businessProfile'])->name('business.show');
Route::get('/sellers/{slug?}', [HomeController::class, 'businessProfile'])->name('sellers.show');
Route::get('/instructor/{slug?}', [HomeController::class, 'businessProfile'])->name('instructor.profile');
Route::post('/business/{slug?}/enquiry', [HomeController::class, 'submitEnquiry'])->name('business.enquiry');
Route::post('/business/{slug?}/demo', [HomeController::class, 'bookDemo'])->name('business.demo');
Route::post('/business/{slug?}/review', [HomeController::class, 'submitReview'])->name('business.review');

Route::get('/login', fn() => redirect()->route('seller.login'))->name('login');

// Seller Registration & Authentication
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/register', [SellerRegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [SellerRegistrationController::class, 'register'])->name('register.submit');
    Route::get('/register/success', [SellerRegistrationController::class, 'success'])->name('register.success');

    Route::get('/login', [SellerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [SellerAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Seller Portal Routes (All Registered Sellers)
|--------------------------------------------------------------------------
*/
Route::prefix('seller')->name('seller.')->middleware(['auth', 'seller'])->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SellerProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [SellerProfileController::class, 'update'])->name('profile.update');

    // Seller Catalog Index Pages (Accessible to see their submissions)
    Route::get('/courses', [SellerCourseController::class, 'index'])->name('courses.index');
    Route::get('/services', [SellerServiceController::class, 'index'])->name('services.index');
    Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
    Route::get('/listings', [SellerBusinessListingController::class, 'index'])->name('listings.index');

    // Orders Management
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/simulate', [SellerOrderController::class, 'simulatePurchase'])->name('orders.simulate');
    Route::get('/orders/export', [SellerOrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');

    // Customer Messages & Chat
    Route::get('/messages', [SellerMessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{conversation}', [SellerMessageController::class, 'send'])->name('messages.send');
    Route::post('/messages/{conversation}/quick-action', [SellerMessageController::class, 'quickAction'])->name('messages.quick-action');

    // Promotions & Marketing Campaigns (Paid Marketing Tiers: 1000, 1500, 2000, 2500)
    Route::get('/promotions', [SellerPromotionController::class, 'index'])->name('promotions.index');
    Route::post('/promotions', [SellerPromotionController::class, 'store'])->name('promotions.store');
    Route::post('/promotions/coupons', [SellerPromotionController::class, 'storeCoupon'])->name('promotions.coupons.store');
    Route::post('/promotions/{promotion}/toggle', [SellerPromotionController::class, 'toggleStatus'])->name('promotions.toggle');

    /*
    |----------------------------------------------------------------------
    | Strictly Protected Selling Routes (Only Approved Active Sellers)
    |----------------------------------------------------------------------
    */
    Route::middleware(['seller.approved'])->group(function () {
        // Course Management
        Route::get('/courses/create', [SellerCourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [SellerCourseController::class, 'store'])->name('courses.store');

        // Service Management
        Route::get('/services/create', [SellerServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [SellerServiceController::class, 'store'])->name('services.store');

        // Product Management
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');

        // Business Directory Listing Management
        Route::get('/listings/create', [SellerBusinessListingController::class, 'create'])->name('listings.create');
        Route::post('/listings', [SellerBusinessListingController::class, 'store'])->name('listings.store');
    });
});

/*
|--------------------------------------------------------------------------
| Super Admin Authentication Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Super Admin Portal Routes (Role: superadmin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile/avatar', [AdminDashboardController::class, 'updateAvatar'])->name('profile.avatar');

    // Users & Members Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/export', [AdminUserController::class, 'export'])->name('export');
    });

    // Seller Approval & Management Workflow
    Route::prefix('sellers')->name('sellers.')->group(function () {
        Route::get('/', [AdminSellerController::class, 'index'])->name('index');
        Route::get('/pending', [AdminSellerController::class, 'pending'])->name('pending');
        Route::get('/{id}', [AdminSellerController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminSellerController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminSellerController::class, 'reject'])->name('reject');
        Route::post('/{id}/suspend', [AdminSellerController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/reactivate', [AdminSellerController::class, 'reactivate'])->name('reactivate');
    });

    // Super Admin Catalog Verification Workflow
    Route::prefix('catalog')->name('catalog.')->group(function () {
        // Courses
        Route::get('/courses', [AdminCatalogController::class, 'courses'])->name('courses');
        Route::post('/courses/{id}/approve', [AdminCatalogController::class, 'approveCourse'])->name('courses.approve');
        Route::post('/courses/{id}/reject', [AdminCatalogController::class, 'rejectCourse'])->name('courses.reject');

        // Services
        Route::get('/services', [AdminCatalogController::class, 'services'])->name('services');
        Route::post('/services/{id}/approve', [AdminCatalogController::class, 'approveService'])->name('services.approve');
        Route::post('/services/{id}/reject', [AdminCatalogController::class, 'rejectService'])->name('services.reject');
        Route::post('/services/{id}/toggle-featured', [AdminCatalogController::class, 'toggleFeaturedService'])->name('services.toggle-featured');

        // Products
        Route::get('/products', [AdminCatalogController::class, 'products'])->name('products');
        Route::post('/products/{id}/approve', [AdminCatalogController::class, 'approveProduct'])->name('products.approve');
        Route::post('/products/{id}/reject', [AdminCatalogController::class, 'rejectProduct'])->name('products.reject');
        Route::post('/products/{id}/toggle-featured', [AdminCatalogController::class, 'toggleFeaturedProduct'])->name('products.toggle-featured');

        // Business Listings
        Route::get('/listings', [AdminCatalogController::class, 'listings'])->name('listings');
        Route::post('/listings/{id}/approve', [AdminCatalogController::class, 'approveListing'])->name('listings.approve');
        Route::post('/listings/{id}/reject', [AdminCatalogController::class, 'rejectListing'])->name('listings.reject');
        Route::post('/listings/{id}/toggle-featured', [AdminCatalogController::class, 'toggleFeaturedListing'])->name('listings.toggle-featured');
    });

    // Customer-Seller Chats Monitoring (Admin Audit & Oversight)
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [AdminMessageController::class, 'index'])->name('index');
        Route::get('/{conversation}', [AdminMessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/moderation-note', [AdminMessageController::class, 'postModerationNote'])->name('moderation-note');
    });

    // Marketplace Promotions & Campaigns (Banners & Promotions Oversight)
    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [AdminPromotionController::class, 'index'])->name('index');
        Route::post('/', [AdminPromotionController::class, 'store'])->name('store');
        Route::get('/export', [AdminPromotionController::class, 'export'])->name('export');
        Route::post('/{id}/toggle-status', [AdminPromotionController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/duplicate', [AdminPromotionController::class, 'duplicate'])->name('duplicate');
        Route::delete('/{id}', [AdminPromotionController::class, 'destroy'])->name('destroy');
        Route::post('/{promotion}/status', [AdminPromotionController::class, 'updateStatus'])->name('status');
    });

    // Coupons & Offers Management
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [AdminCouponController::class, 'index'])->name('index');
        Route::post('/', [AdminCouponController::class, 'store'])->name('store');
        Route::get('/export', [AdminCouponController::class, 'export'])->name('export');
        Route::post('/{id}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/duplicate', [AdminCouponController::class, 'duplicate'])->name('duplicate');
        Route::delete('/{id}', [AdminCouponController::class, 'destroy'])->name('destroy');
    });

    // Coming Soon placeholders for future admin modules
    Route::get('/module/{module}', [AdminDashboardController::class, 'comingSoon'])->name('coming-soon');
});
