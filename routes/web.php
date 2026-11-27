<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminApiController;
use App\Http\Controllers\Admin\AdminAppController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCatalogController;
use App\Http\Controllers\Admin\AdminCmsController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFinancialController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminModuleController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminSeoController;
use App\Http\Controllers\Admin\AdminSellerController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWebsiteController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\SellerRegistrationController;
use App\Http\Controllers\Customer\CustomerCourseController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\SellerBusinessListingController;
use App\Http\Controllers\Seller\SellerCourseController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerMediaController;
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

// Shopping Cart & Checkout API Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkoutPage'])->name('checkout');
Route::get('/cart/checkout', [CartController::class, 'checkoutPage']);
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'checkout']);

// Coupon Validation API
Route::post('/coupons/validate', [CouponController::class, 'validateCoupon'])->name('coupons.validate');
Route::get('/coupons/available', [CouponController::class, 'getAvailableCoupons'])->name('coupons.available');
Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/service/{slug}', [HomeController::class, 'serviceShow'])->name('service.show');
Route::post('/service/{slug}/book', [HomeController::class, 'serviceBook'])->name('service.book');
Route::post('/service/{slug}/quote', [HomeController::class, 'serviceQuote'])->name('service.quote');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/businesses', [HomeController::class, 'businesses'])->name('businesses');
Route::get('/product/{slug}', [HomeController::class, 'productShow'])->name('product.show');
Route::get('/course/{slug}', [HomeController::class, 'courseShow'])->name('course.show');
Route::post('/course/{slug}/enroll', [HomeController::class, 'courseEnroll'])->name('course.enroll');
Route::post('/course/{slug}/review', [HomeController::class, 'courseReview'])->name('course.review');
Route::get('/course/{slug}/certificate', [CertificateController::class, 'forCourse'])->name('course.certificate');
Route::get('/certificate/{code?}', [CertificateController::class, 'show'])->name('certificate.show');
// Legacy directory routes: redirect to /businesses with corresponding filters
Route::get('/business-listing/category/{category}', function ($category) {
    return redirect()->route('businesses', ['category' => str_replace('-', ' ', $category)], 301);
});
Route::get('/business-listing/state/{state}', function ($state) {
    return redirect()->route('businesses', ['state' => str_replace('-', ' ', $state)], 301);
});
Route::get('/business-listing/city/{city}', function ($city) {
    return redirect()->route('businesses', ['city' => str_replace('-', ' ', $city)], 301);
});
Route::get('/business-listing/coaching-institutes', function () {
    return redirect()->route('businesses', ['category' => 'Coaching Institute'], 301);
});
Route::get('/business-listing/training-institutes', function () {
    return redirect()->route('businesses', ['category' => 'Training Institute'], 301);
});

// Business Directory Institute Course (Legacy format matching /business-listing/course/{id}/{slug})
Route::get('/business-listing/course/{id}/{slug?}', [HomeController::class, 'instituteCourseShow'])->name('business.course.show');

// Business Directory Listing Public Profile matching target SEO format:
// e.g. /business-listing/coaching/prarthna-paramedical-institute
Route::get('/business-listing/{category}/{slug}', [HomeController::class, 'businessProfile'])->name('business.show');
Route::get('/business-listing/{slug}', [HomeController::class, 'businessProfile'])->name('business.show.single');

// E-Learning Tutor Profile & Courses (Legacy format matching /e-learning/tutor/{slug}/{id})
Route::get('/e-learning/tutor/{slug}/{id}', [HomeController::class, 'tutorProfile'])->name('tutor.profile');
Route::get('/e-learning/tutor/{id}', [HomeController::class, 'tutorProfile']);
Route::get('/tutor/{slug}/{id}', [HomeController::class, 'tutorProfile']);
Route::get('/e-learning/course/{id}/{slug?}', [HomeController::class, 'elearnCourseShow'])->name('elearn.course.show');
Route::get('/e-learning/course/{slug}', [HomeController::class, 'elearnCourseShow']);

// Legacy 301 redirects from /business/{slug} and /sellers/{slug} to /business-listing/{category}/{slug}
Route::get('/business/{slug?}', [HomeController::class, 'businessProfileLegacyRedirect']);
Route::get('/sellers/{slug?}', [HomeController::class, 'businessProfileLegacyRedirect'])->name('sellers.show');
Route::get('/instructor/{slug?}', [HomeController::class, 'businessProfileLegacyRedirect'])->name('instructor.profile');

Route::post('/business-listing/{category}/{slug}/enquiry', [HomeController::class, 'submitEnquiry']);
Route::post('/business-listing/{slug}/enquiry', [HomeController::class, 'submitEnquiry']);
Route::post('/business/{slug?}/enquiry', [HomeController::class, 'submitEnquiry'])->name('business.enquiry');

Route::post('/business-listing/{category}/{slug}/demo', [HomeController::class, 'bookDemo']);
Route::post('/business-listing/{slug}/demo', [HomeController::class, 'bookDemo']);
Route::post('/business/{slug?}/demo', [HomeController::class, 'bookDemo'])->name('business.demo');

Route::post('/business-listing/{category}/{slug}/review', [HomeController::class, 'submitReview']);
Route::post('/business-listing/{slug}/review', [HomeController::class, 'submitReview']);
Route::post('/business/{slug?}/review', [HomeController::class, 'submitReview'])->name('business.review');

// High-Converting SEO Landing Pages & XML Sitemap
Route::get('/online-course-selling-platform', [HomeController::class, 'sellCoursesLanding'])->name('sell-courses.landing');
Route::get('/sell-courses', [HomeController::class, 'sellCoursesLanding'])->name('sell-courses');
Route::get('/become-seller', [HomeController::class, 'sellCoursesLanding'])->name('become-seller');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap.xml');
Route::get('/googlef8ebe72df07d405f.html', function () {
    return response('google-site-verification: googlef8ebe72df07d405f.html', 200, ['Content-Type' => 'text/html']);
});

// Public Blog Directory & Article Reader
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogController::class, 'comment'])->name('blog.comment');

// Customer Authentication & Order History
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');
Route::match(['get', 'post'], '/logout', [CustomerAuthController::class, 'logout'])->name('logout');

Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('customer.dashboard'));
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.submit');
    Route::match(['get', 'post'], '/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    Route::get('/orders', [CustomerAuthController::class, 'orders'])->name('orders');
    Route::get('/profile', [CustomerAuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/account', fn() => redirect()->route('customer.dashboard'))->name('account');

    // Student Learning Portal & Video Lecture Classroom
    Route::get('/my-courses', [CustomerCourseController::class, 'myCourses'])->name('my-courses');
    Route::get('/learning', [CustomerCourseController::class, 'myCourses'])->name('learning');
    Route::get('/course/{courseId}/learn/{lessonId?}', [CustomerCourseController::class, 'player'])->name('course.learn');
    Route::post('/learning/{courseId}/lesson/{lessonId}/toggle', [CustomerCourseController::class, 'toggleLesson'])->name('course.lesson.toggle');
    Route::post('/learning/{courseId}/lesson/{lessonId}/note', [CustomerCourseController::class, 'saveNote'])->name('course.lesson.note');
    Route::post('/course/{courseId}/enroll-free', [CustomerCourseController::class, 'enrollFree'])->name('course.enroll.free');
    Route::get('/course/{courseId}/certificate', [CustomerCourseController::class, 'certificate'])->name('course.certificate');
});

// Convenient Top-Level Aliases for Student Learning & Customer Dashboard
Route::get('/dashboard', fn() => Auth::check() && Auth::user()->isSeller() ? redirect()->route('seller.dashboard') : redirect()->route('customer.dashboard'))->name('dashboard');
Route::get('/student/dashboard', [CustomerDashboardController::class, 'index']);
Route::get('/my-courses', [CustomerCourseController::class, 'myCourses']);
Route::get('/my-learning', [CustomerCourseController::class, 'myCourses']);
Route::get('/student/classroom/{courseId}/{lessonId?}', [CustomerCourseController::class, 'player']);

Route::get('/account', fn() => redirect()->route('customer.dashboard'));

Route::get('/refresh-csrf', fn() => response()->json(['token' => csrf_token()]))->name('refresh-csrf');

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

    // Instant Media & Video Upload (Courses, Services, Products, Listings)
    Route::post('/media/upload', [SellerMediaController::class, 'upload'])->name('media.upload');

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
| Supports both /admin and /super/admin paths
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Alias routes for /super/admin/... URL pattern
Route::prefix('super/admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('super.admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('super.admin.login.submit');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('super.admin.logout');
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));
});

/*
|--------------------------------------------------------------------------
| Protected Super Admin Portal Routes (Role: superadmin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['superadmin'])->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile/avatar', [AdminDashboardController::class, 'updateAvatar'])->name('profile.avatar');

    // Users & Members Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/export', [AdminUserController::class, 'export'])->name('export');
        Route::post('/{id}/note', [AdminUserController::class, 'storeNote'])->name('note.store');
        Route::delete('/notes/{id}', [AdminUserController::class, 'deleteNote'])->name('note.delete');
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

    // Orders & Bookings Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/export', [AdminOrderController::class, 'export'])->name('export');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('status');
        Route::post('/simulate', [AdminOrderController::class, 'simulateOrder'])->name('simulate');
        Route::delete('/{id}', [AdminOrderController::class, 'destroy'])->name('destroy');
    });

    // Financial Management (Payments & Payouts)
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/payments', [AdminFinancialController::class, 'payments'])->name('payments');
        Route::get('/payouts', [AdminFinancialController::class, 'payouts'])->name('payouts');
        Route::post('/payouts/{sellerId}/release', [AdminFinancialController::class, 'releasePayout'])->name('payouts.release');
        Route::get('/refunds', [AdminFinancialController::class, 'refunds'])->name('refunds');
        Route::post('/refunds/{id}/approve', [AdminFinancialController::class, 'approveRefund'])->name('refunds.approve');
        Route::post('/refunds/{id}/reject', [AdminFinancialController::class, 'rejectRefund'])->name('refunds.reject');
    });

    // Customer-Seller Chats Monitoring & Support Tickets (Admin Messages & Support)
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [AdminMessageController::class, 'index'])->name('index');
        Route::get('/export', [AdminMessageController::class, 'export'])->name('export');
        Route::post('/tickets', [AdminMessageController::class, 'storeTicket'])->name('tickets.store');
        Route::post('/tickets/{id}/reply', [AdminMessageController::class, 'sendMessage'])->name('tickets.reply');
        Route::post('/tickets/{id}/status', [AdminMessageController::class, 'updateStatus'])->name('tickets.status');
        Route::post('/tickets/{id}/assign', [AdminMessageController::class, 'assign'])->name('tickets.assign');
        Route::delete('/tickets/{id}', [AdminMessageController::class, 'destroy'])->name('tickets.destroy');
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
        Route::get('/create', [AdminCouponController::class, 'create'])->name('create');
        Route::post('/', [AdminCouponController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminCouponController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch', 'post'], '/{id}', [AdminCouponController::class, 'update'])->name('update');
        Route::get('/export', [AdminCouponController::class, 'export'])->name('export');
        Route::post('/{id}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/duplicate', [AdminCouponController::class, 'duplicate'])->name('duplicate');
        Route::delete('/{id}', [AdminCouponController::class, 'destroy'])->name('destroy');
    });

    // Reviews & Ratings Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('index');
        Route::get('/export', [AdminReviewController::class, 'export'])->name('export');
        Route::post('/{id}/approve', [AdminReviewController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminReviewController::class, 'reject'])->name('reject');
        Route::post('/{id}/feature', [AdminReviewController::class, 'toggleFeatured'])->name('feature');
        Route::post('/{id}/note', [AdminReviewController::class, 'saveNote'])->name('note');
        Route::delete('/{id}', [AdminReviewController::class, 'destroy'])->name('destroy');
    });

    // Marketing & Leads Management
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [AdminLeadController::class, 'index'])->name('index');
        Route::post('/', [AdminLeadController::class, 'store'])->name('store');
        Route::get('/export', [AdminLeadController::class, 'export'])->name('export');
        Route::post('/{id}/status', [AdminLeadController::class, 'updateStatus'])->name('status');
        Route::post('/{id}/schedule-demo', [AdminLeadController::class, 'scheduleDemo'])->name('schedule-demo');
        Route::post('/{id}/note', [AdminLeadController::class, 'addNote'])->name('note');
        Route::delete('/{id}', [AdminLeadController::class, 'destroy'])->name('destroy');
    });

    // Blog & CMS Management
    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/', [AdminCmsController::class, 'index'])->name('index');
        Route::get('/create', [AdminCmsController::class, 'create'])->name('create');
        Route::post('/', [AdminCmsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminCmsController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch', 'post'], '/{id}', [AdminCmsController::class, 'update'])->name('update');
        Route::post('/{id}/toggle-status', [AdminCmsController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/export', [AdminCmsController::class, 'export'])->name('export');
        Route::delete('/{id}', [AdminCmsController::class, 'destroy'])->name('destroy');
    });

    // Notifications & Broadcasts Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [AdminNotificationController::class, 'index'])->name('index');
        Route::post('/', [AdminNotificationController::class, 'store'])->name('store');
        Route::post('/{id}/resend', [AdminNotificationController::class, 'resend'])->name('resend');
        Route::get('/export', [AdminNotificationController::class, 'export'])->name('export');
        Route::delete('/{id}', [AdminNotificationController::class, 'destroy'])->name('destroy');
    });

    // App Management (Android, iOS & PWA control studio)
    Route::prefix('app')->name('app.')->group(function () {
        Route::get('/', [AdminAppController::class, 'index'])->name('index');
        Route::post('/info', [AdminAppController::class, 'updateInfo'])->name('update-info');
        Route::post('/features/{id}/toggle', [AdminAppController::class, 'toggleFeature'])->name('features.toggle');
        Route::post('/publish', [AdminAppController::class, 'publishVersion'])->name('publish');
    });

    // Website Management (Pages, navigation, settings studio)
    Route::prefix('website')->name('website.')->group(function () {
        Route::get('/', [AdminWebsiteController::class, 'index'])->name('index');
        Route::post('/', [AdminWebsiteController::class, 'store'])->name('store');
        Route::match(['put', 'patch', 'post'], '/{id}', [AdminWebsiteController::class, 'update'])->name('update');
        Route::post('/{id}/duplicate', [AdminWebsiteController::class, 'duplicate'])->name('duplicate');
        Route::delete('/{id}', [AdminWebsiteController::class, 'destroy'])->name('destroy');
    });

    // SEO Management & Traffic Studio
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [AdminSeoController::class, 'index'])->name('index');
        Route::match(['put', 'patch', 'post'], '/', [AdminSeoController::class, 'update'])->name('update');
        Route::post('/sitemap', [AdminSeoController::class, 'generateSitemap'])->name('sitemap');
    });

    // Reports & Analytics Studio
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/export', [AdminReportController::class, 'export'])->name('export');
    });

    // General Marketplace Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
        Route::match(['put', 'patch', 'post'], '/', [AdminSettingsController::class, 'update'])->name('update');
    });

    // Roles & Permissions (Staff RBAC)
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [AdminRoleController::class, 'index'])->name('index');
        Route::post('/', [AdminRoleController::class, 'store'])->name('store');
        Route::post('/staff', [AdminRoleController::class, 'storeStaff'])->name('staff.store');
    });

    // Activity Logs & Audit Trail
    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/', [AdminActivityController::class, 'index'])->name('index');
        Route::get('/export', [AdminActivityController::class, 'export'])->name('export');
    });

    // Modules & Feature Switches
    Route::prefix('modules')->name('modules.')->group(function () {
        Route::get('/', [AdminModuleController::class, 'index'])->name('index');
        Route::post('/{key}/toggle', [AdminModuleController::class, 'toggle'])->name('toggle');
        Route::post('/update', [AdminModuleController::class, 'update'])->name('update');
    });

    // API & Third-Party Integrations
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/', [AdminApiController::class, 'index'])->name('index');
        Route::post('/regenerate', [AdminApiController::class, 'regenerate'])->name('regenerate');
        Route::post('/update', [AdminApiController::class, 'update'])->name('update');
        Route::post('/test-webhook', [AdminApiController::class, 'testWebhook'])->name('test-webhook');
    });

    // Coming Soon placeholders for future admin modules
    Route::get('/module/{module}', [AdminDashboardController::class, 'comingSoon'])->name('coming-soon');
});
