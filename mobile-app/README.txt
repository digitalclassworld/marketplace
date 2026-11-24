================================================================================
DIGITAL CLASS MARKETPLACE - MOBILE APP REST API DOCUMENTATION SUITE
================================================================================

Welcome to the official REST API specification for Digital Class Marketplace mobile 
applications (Android, iOS, Flutter, React Native).

This directory contains standalone, detailed technical documentation files for each 
API module so mobile engineers can easily read, copy, test, and integrate every endpoint.

--------------------------------------------------------------------------------
DIRECTORY INDEX & FILE ROADMAP
--------------------------------------------------------------------------------

File Name                                         Description
--------------------------------------------------------------------------------
00_GENERAL_INFO_AND_HEADERS.txt                   Base URLs, Standard Headers, Auth Token & CSRF Rules
01_APP_CONFIG_AND_HOME_FEED_API.txt               App Version, Feature Flags, Maintenance, Home Feed
02_AUTHENTICATION_AND_CUSTOMER_PROFILE_API.txt    Register, Login, Profile View/Edit, Logout
03_ONLINE_COURSES_API.txt                         Courses Directory, Search, Filters, Curriculum, Detail
04_PROFESSIONAL_SERVICES_AND_BOOKING_API.txt      Freelance & Business Services, Packages, Booking Leads
05_PRODUCTS_CATALOG_API.txt                       Marketplace Products, Filter by Brand/Category, Detail
06_BUSINESS_DIRECTORY_AND_INSTITUTES_API.txt      Verified Coaching Institutes, Enquiry, Free Demo Class
07_CATEGORIES_DIRECTORY_API.txt                   Marketplace Taxonomy & Hierarchical Categories
08_CART_AND_CHECKOUT_API.txt                      Cart CRUD, Razorpay, Bank Transfer, Offline COD Checkout
09_ORDERS_AND_ENROLLMENTS_API.txt                 Purchase History, Order Status, Invoice Receipts
10_COUPONS_AND_DISCOUNTS_API.txt                  Available Coupons (WELCOME10, DIGITAL20, DIWALI50), Validation
11_ERROR_CODES_AND_HANDLING.txt                   HTTP Status Codes, Error JSON Schema, Validation Messages
12_ALL_APIS_COMPLETE_SPECIFICATION.txt            Complete Master Documentation with All Endpoints in One File

--------------------------------------------------------------------------------
BASE URLS
--------------------------------------------------------------------------------
Production API Server:    https://web.digitalclassworld.in/api
Main Domain Server:       https://digitalclassworld.com/api
Local Development Server: http://localhost:8000/api

--------------------------------------------------------------------------------
CORE CONVENTIONS
--------------------------------------------------------------------------------
1. JSON Format: Always send "Accept: application/json" and "Content-Type: application/json".
2. CSRF Exemption: All routes under /api/* are completely stateless and CSRF-exempt.
3. Auth Mechanism: Bearer tokens generated on login/register: "Authorization: Bearer <TOKEN>".
4. Currency: Indian Rupees (INR, symbol: ₹).
5. Character Set: UTF-8.

For technical support or backend queries, contact the backend engineering team:
Email: support@digitalclassworld.in
Website: https://web.digitalclassworld.in
================================================================================

