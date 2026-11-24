# Digital Class Marketplace - Mobile App REST API Documentation

This document provides complete technical specifications for Android, iOS, Flutter, and React Native mobile app developers building or integrating client applications with the **Digital Class Marketplace** backend.

---

## 1. General API Information

### Base URLs
- **Production Server:** `https://web.digitalclassworld.in/api`
- **Main Domain:** `https://digitalclassworld.com/api`
- **Local Development:** `http://localhost:8000/api`

### Common Headers
All API requests sent by the mobile app should include the following standard headers:

| Header | Value | Description |
| :--- | :--- | :--- |
| `Accept` | `application/json` | Guarantees JSON response format from Laravel |
| `Content-Type` | `application/json` | Required for `POST`, `PUT`, `PATCH` requests |
| `Authorization` | `Bearer <API_TOKEN>` | Required for authenticated endpoints |
| `X-Platform` | `android` or `ios` | Optional: platform identifier |

> **CSRF Exemption:** All routes under `/api/*` are state-independent and CSRF-exempt. Mobile developers do not need to fetch or send CSRF tokens for API calls.

---

## 2. API Endpoints Catalog

### Summary Table

| Category | Method | Endpoint | Description | Auth Required |
| :--- | :--- | :--- | :--- | :--- |
| **App & Config** | `GET` | `/api/app/config` | App version, maintenance status, active feature flags | No |
| **App & Config** | `GET` | `/api/home/feed` | Homepage feed (banners, top courses, services, businesses, products) | No |
| **Auth** | `POST` | `/api/auth/register` | Customer sign-up with profession & details | No |
| **Auth** | `POST` | `/api/auth/login` | Sign-in via Email or Phone | No |
| **Auth** | `GET` | `/api/auth/profile` | Current customer profile | Yes |
| **Auth** | `PUT` | `/api/auth/profile` | Update profile details | Yes |
| **Auth** | `POST` | `/api/auth/logout` | Revoke session/token | Yes |
| **Courses** | `GET` | `/api/courses` | Search & filter online courses | No |
| **Courses** | `GET` | `/api/courses/{id}` | Course detail with curriculum & instructor | No |
| **Services** | `GET` | `/api/services` | Search & list professional services | No |
| **Services** | `GET` | `/api/services/{id}` | Service details, packages, FAQs | No |
| **Services** | `POST` | `/api/services/{id}/book`| Submit service booking lead | No |
| **Products** | `GET` | `/api/products` | Search physical & digital products | No |
| **Products** | `GET` | `/api/products/{id}` | Product details, specs, stock | No |
| **Businesses**| `GET` | `/api/businesses` | Verified institutes & businesses (Premium first) | No |
| **Businesses**| `GET` | `/api/businesses/{id}`| Business profile, branches, courses | No |
| **Businesses**| `POST`| `/api/businesses/{id}/enquiry` | Send business enquiry lead | No |
| **Businesses**| `POST`| `/api/businesses/{id}/demo` | Book free demo class | No |
| **Categories**| `GET` | `/api/categories` | Marketplace categories directory | No |
| **Cart** | `GET` | `/api/cart` | View items in shopping cart | No |
| **Cart** | `POST` | `/api/cart/add` | Add course, product, or service to cart | No |
| **Cart** | `POST` | `/api/cart/update` | Update item quantity | No |
| **Cart** | `POST` | `/api/cart/remove` | Remove single item from cart | No |
| **Cart** | `POST` | `/api/cart/clear` | Empty shopping cart | No |
| **Cart** | `POST` | `/api/cart/checkout` | Submit order with billing details | No |
| **Orders** | `GET` | `/api/orders` | Customer order history | Yes / Email |
| **Coupons** | `GET` | `/api/coupons/available` | Active discount coupons | No |
| **Coupons** | `POST` | `/api/coupons/validate` | Check promo code & calculate discount | No |

---

## 3. Detailed Endpoint Specifications

### 3.1. App Configuration & Control
#### `GET /api/app/config`
Retrieves app runtime configuration, minimum supported version, and feature flags.

- **Query Parameters:**
  - `platform` (`string`, optional): `android` or `ios` (default: `android`)
- **Sample Response:**
```json
{
  "success": true,
  "data": {
    "app_name": "Digital Class",
    "platform": "android",
    "package_name": "com.digitalclass.app",
    "current_version": "v2.4.0",
    "min_supported_ver": "v1.0.0",
    "force_update": false,
    "status": "Live",
    "rating": 4.6,
    "features": [
      {
        "key": "course_player",
        "name": "Course Video Player",
        "is_enabled": true
      },
      {
        "key": "business_directory",
        "name": "Local Business Directory",
        "is_enabled": true
      }
    ],
    "support_contact": {
      "email": "support@digitalclassworld.com",
      "phone": "+91 9999999999",
      "whatsapp": "+91 9999999999"
    }
  }
}
```

---

#### `GET /api/home/feed`
Aggregated payload for the mobile homepage.
- **Includes:**
  - Banners carousel (`banners`)
  - Featured online courses (`featured_courses`)
  - Top professional services (`featured_services`)
  - Verified local businesses & coaching institutes (`popular_businesses`)
  - Trending products (`featured_products`)
  - Marketplace statistics (`stats`)

---

### 3.2. Authentication & User Profile

#### `POST /api/auth/register`
Creates a new customer account.
- **Request Body (JSON):**
```json
{
  "name": "Rahul Sharma",
  "email": "rahul.sharma@example.com",
  "phone": "9876543210",
  "profession": "Software Engineer",
  "city": "Ahmedabad",
  "state": "Gujarat",
  "password": "SecurePassword123"
}
```
- **Response (201 Created):**
```json
{
  "success": true,
  "message": "Account created successfully!",
  "token": "eyJpZCI6MTU...",
  "user": {
    "id": 15,
    "name": "Rahul Sharma",
    "email": "rahul.sharma@example.com",
    "phone": "9876543210",
    "profession": "Software Engineer",
    "avatar": "https://ui-avatars.com/api/?name=Rahul+Sharma...",
    "city": "Ahmedabad",
    "state": "Gujarat",
    "role": "customer"
  }
}
```

---

#### `POST /api/auth/login`
Authenticates a user via Email or Phone.
- **Request Body (JSON):**
```json
{
  "email": "rahul.sharma@example.com",
  "password": "SecurePassword123"
}
```
- **Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "token": "eyJpZCI6MTU...",
  "user": {
    "id": 15,
    "name": "Rahul Sharma",
    "email": "rahul.sharma@example.com",
    "phone": "9876543210",
    "profession": "Software Engineer",
    "avatar": "https://ui-avatars.com/...",
    "role": "customer"
  }
}
```

---

#### `GET /api/auth/profile`
Returns current authenticated user details.
- **Headers:** `Authorization: Bearer <TOKEN>`

#### `PUT /api/auth/profile`
Updates user profile fields (`name`, `phone`, `profession`, `city`, `state`, `interests`).

---

### 3.3. Courses Catalog

#### `GET /api/courses`
Lists available online video courses.
- **Query Parameters:**
  - `search` (`string`, optional): keyword search in title & description
  - `category` (`string`, optional): category filter
  - `sort` (`string`, optional): `latest`, `popular`, `price_low`, `price_high`
  - `page` (`integer`, optional): page number (default: 1)
  - `per_page` (`integer`, optional): items per page (default: 12, max: 50)
- **Response Sample:**
```json
{
  "success": true,
  "data": [
    {
      "id": 2350,
      "title": "Shopify Dropshipping Course",
      "slug": "shopify-dropshipping-course",
      "price": 4999.00,
      "discount_price": 2999.00,
      "rating": 4.8,
      "reviews_count": 124,
      "short_desc": "Learn how to build a high-converting eCommerce store...",
      "thumbnail": "https://web.digitalclassworld.in/...",
      "duration": "18 Hours",
      "language": "Hindi/English",
      "skill_level": "Beginner to Advanced"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 91,
    "per_page": 12,
    "total": 1084
  }
}
```

#### `GET /api/courses/{id}`
Returns full course details including what you will learn, curriculum counts, and instructor profile.

---

### 3.4. Professional Services

#### `GET /api/services`
Lists service gigs (web development, digital marketing, graphic design, tutoring, etc.).

#### `GET /api/services/{id}`
Returns service details, pricing packages, delivery timeline, and buyer requirements.

#### `POST /api/services/{id}/book`
Submits a service booking request.
- **Request Body:**
```json
{
  "name": "Sunita Verma",
  "email": "sunita@example.com",
  "phone": "9876543210",
  "message": "Need website redesign for my coaching institute.",
  "date": "2026-12-01"
}
```

---

### 3.5. Products Catalog

#### `GET /api/products`
Lists physical products, books, stationery, and hardware.
- **Query Parameters:** `search`, `category`, `sort`, `page`, `per_page`

#### `GET /api/products/{id}`
Returns specifications, stock quantity, SKU, and seller details.

---

### 3.6. Business Listings & Institutes Directory

#### `GET /api/businesses`
Searches verified businesses, schools, training institutes, and academies.
- **Smart Priority:** Automatically ranks **Premium** and **Featured** business listings first in the results.
- **Query Parameters:**
  - `search` (`string`, optional)
  - `city` (`string`, optional, e.g. `Mumbai`, `Delhi`, `Ahmedabad`, `Bengaluru`)
  - `state` (`string`, optional, e.g. `Gujarat`, `Maharashtra`, `Karnataka`, `Bihar`)
  - `category` (`string`, optional, e.g. `Coaching Institute`, `Computer Classes`)
  - `page` (`integer`, optional)
  - `per_page` (`integer`, optional)

#### `GET /api/businesses/{id}`
Returns business profile, address, coordinates, branches, courses offered, photos, and direct WhatsApp/Phone contact.

#### `POST /api/businesses/{id}/enquiry`
Direct enquiry submission to the business owner:
```json
{
  "name": "Amit Patel",
  "email": "amit@example.com",
  "phone": "9898989898",
  "message": "Interested in Batch Timings and Fee details."
}
```

#### `POST /api/businesses/{id}/demo`
Book a free demo class with an institute:
```json
{
  "name": "Amit Patel",
  "email": "amit@example.com",
  "phone": "9898989898",
  "course": "Full Stack Python",
  "date": "Tomorrow 10:00 AM"
}
```

---

### 3.7. Shopping Cart & Checkout

#### `GET /api/cart`
Returns current items in the cart, quantity, and total price.

#### `POST /api/cart/add`
Adds an item to the shopping cart.
- **Request Body:**
```json
{
  "id": 2350,
  "type": "Course",
  "title": "Shopify Dropshipping Course",
  "price": 2999.00,
  "thumbnail": "https://...",
  "quantity": 1
}
```

#### `POST /api/cart/update`
Update quantity of an item:
```json
{
  "key": "course_2350",
  "quantity": 2
}
```

#### `POST /api/cart/remove`
Removes an item (`{"key": "course_2350"}`).

#### `POST /api/cart/clear`
Clears all items in the cart.

#### `POST /api/cart/checkout`
Places order for items in the cart.
- **Request Body:**
```json
{
  "name": "Rahul Sharma",
  "email": "rahul.sharma@example.com",
  "phone": "9876543210",
  "city": "Ahmedabad",
  "state": "Gujarat",
  "address": "402, High Street Complex, CG Road",
  "pincode": "380009",
  "payment_method": "upi"
}
```
- **Response (201 Created):**
```json
{
  "success": true,
  "message": "Order placed successfully!",
  "order_number": "ORD-AB12CD34",
  "total_amount": 2999.00,
  "order_ids": [45]
}
```

---

### 3.8. Orders History

#### `GET /api/orders`
Retrieves past order history.
- **Headers:** `Authorization: Bearer <TOKEN>` or Query: `?email=rahul.sharma@example.com`

---

### 3.9. Coupons & Discounts

#### `GET /api/coupons/available`
Returns active coupons that customers can apply.

#### `POST /api/coupons/validate`
Validates a coupon code against a subtotal.
- **Request Body:**
```json
{
  "code": "WELCOME10",
  "total": 2999.00
}
```
- **Response:**
```json
{
  "success": true,
  "coupon_code": "WELCOME10",
  "discount_amount": 299.90,
  "final_total": 2699.10,
  "message": "Coupon WELCOME10 applied successfully!"
}
```

---

## 4. Mobile Integration Guide

### Recommended Network Client Setup
#### Flutter (`dio` / `http`)
```dart
final dio = Dio(BaseOptions(
  baseUrl: 'https://web.digitalclassworld.in/api',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
));

// Attaching token dynamically
dio.interceptors.add(InterceptorsWrapper(
  onRequest: (options, handler) async {
    final token = await storage.read(key: 'auth_token');
    if (token != null) {
      options.headers['Authorization'] = 'Bearer $token';
    }
    return handler.next(options);
  },
  
));
```

#### React Native (`axios`)
```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'https://web.digitalclassworld.in/api',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

api.interceptors.request.use(async (config) => {
  const token = await AsyncStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
```

#### Android / Kotlin (`Retrofit` + `OkHttpClient`)
```kotlin
val okHttpClient = OkHttpClient.Builder()
    .addInterceptor { chain ->
        val original = chain.request()
        val requestBuilder = original.newBuilder()
            .header("Accept", "application/json")
            .header("Content-Type", "application/json")
        val token = EncryptedSharedPrefs.getToken(context)
        if (!token.isNullOrEmpty()) {
            requestBuilder.header("Authorization", "Bearer $token")
        }
        chain.proceed(requestBuilder.build())
    }
    .build()

val retrofit = Retrofit.Builder()
    .baseUrl("https://web.digitalclassworld.in/api/")
    .client(okHttpClient)
    .addConverterFactory(GsonConverterFactory.create())
    .build()
```

#### iOS / Swift (`URLSession` / `Async/Await`)
```swift
func makeApiRequest(endpoint: String, method: String = "GET", body: Data? = nil) async throws -> Data {
    guard let url = URL(string: "https://web.digitalclassworld.in/api/\(endpoint)") else {
        throw URLError(.badURL)
    }
    var request = URLRequest(url: url)
    request.httpMethod = method
    request.setValue("application/json", forHTTPHeaderField: "Accept")
    request.setValue("application/json", forHTTPHeaderField: "Content-Type")
    if let token = KeychainHelper.shared.getToken() {
        request.setValue("Bearer \(token)", forHTTPHeaderField: "Authorization")
    }
    request.httpBody = body
    let (data, response) = try await URLSession.shared.data(for: request)
    return data
}
```

---

## 5. Standalone Module TXT Files in Repository

For convenience, mobile developers can find individual standalone `.txt` documentation files partitioned by module inside the `mobile-app/` and `mobile app/` directories:

- `mobile-app/00_GENERAL_INFO_AND_HEADERS.txt`
- `mobile-app/01_APP_CONFIG_AND_HOME_FEED_API.txt`
- `mobile-app/02_AUTHENTICATION_AND_CUSTOMER_PROFILE_API.txt`
- `mobile-app/03_ONLINE_COURSES_API.txt`
- `mobile-app/04_PROFESSIONAL_SERVICES_AND_BOOKING_API.txt`
- `mobile-app/05_PRODUCTS_CATALOG_API.txt`
- `mobile-app/06_BUSINESS_DIRECTORY_AND_INSTITUTES_API.txt`
- `mobile-app/07_CATEGORIES_DIRECTORY_API.txt`
- `mobile-app/08_CART_AND_CHECKOUT_API.txt`
- `mobile-app/09_ORDERS_AND_ENROLLMENTS_API.txt`
- `mobile-app/10_COUPONS_AND_DISCOUNTS_API.txt`
- `mobile-app/11_ERROR_CODES_AND_HANDLING.txt`
- `mobile-app/12_ALL_APIS_COMPLETE_SPECIFICATION.txt`

---
*Generated by Digital Class Engineering Team for Mobile App Developers.*
