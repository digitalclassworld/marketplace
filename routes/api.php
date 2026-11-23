<?php

use App\Http\Controllers\Api\MobileApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile & REST API Routes
|--------------------------------------------------------------------------
| All routes in this file are automatically prefixed with '/api'.
| Mobile apps can interact directly without CSRF token constraints.
*/

// 1. App Configuration & Home Screen Feed
Route::get('/app/config', [MobileApiController::class, 'appConfig']);
Route::get('/home/feed', [MobileApiController::class, 'homeFeed']);

// 2. Authentication & Customer Profile
Route::prefix('auth')->group(function () {
    Route::post('/login', [MobileApiController::class, 'authLogin']);
    Route::post('/register', [MobileApiController::class, 'authRegister']);
    Route::get('/profile', [MobileApiController::class, 'authProfile']);
    Route::put('/profile', [MobileApiController::class, 'authUpdateProfile']);
    Route::post('/logout', [MobileApiController::class, 'authLogout']);
});

// 3. Online Courses Catalog
Route::prefix('courses')->group(function () {
    Route::get('/', [MobileApiController::class, 'courses']);
    Route::get('/{id}', [MobileApiController::class, 'courseShow']);
});

// 4. Professional Services
Route::prefix('services')->group(function () {
    Route::get('/', [MobileApiController::class, 'services']);
    Route::get('/{id}', [MobileApiController::class, 'serviceShow']);
    Route::post('/{id}/book', [MobileApiController::class, 'serviceBook']);
});

// 5. Products Catalog
Route::prefix('products')->group(function () {
    Route::get('/', [MobileApiController::class, 'products']);
    Route::get('/{id}', [MobileApiController::class, 'productShow']);
});

// 6. Business Directory & Institutes
Route::prefix('businesses')->group(function () {
    Route::get('/', [MobileApiController::class, 'businesses']);
    Route::get('/{id}', [MobileApiController::class, 'businessShow']);
    Route::post('/{id}/enquiry', [MobileApiController::class, 'businessEnquiry']);
    Route::post('/{id}/demo', [MobileApiController::class, 'businessDemo']);
});

// 7. Categories
Route::get('/categories', [MobileApiController::class, 'categories']);

// 8. Shopping Cart & Checkout
Route::prefix('cart')->group(function () {
    Route::get('/', [MobileApiController::class, 'cartIndex']);
    Route::post('/add', [MobileApiController::class, 'cartAdd']);
    Route::post('/update', [MobileApiController::class, 'cartUpdate']);
    Route::post('/remove', [MobileApiController::class, 'cartRemove']);
    Route::post('/clear', [MobileApiController::class, 'cartClear']);
    Route::post('/checkout', [MobileApiController::class, 'cartCheckout']);
});

// 9. Orders
Route::get('/orders', [MobileApiController::class, 'myOrders']);

// 10. Coupons & Discounts
Route::prefix('coupons')->group(function () {
    Route::get('/available', [MobileApiController::class, 'couponsAvailable']);
    Route::post('/validate', [MobileApiController::class, 'couponValidate']);
});
