# New Database Schema Analysis (`marketplace`)

**Application:** Digital Class Marketplace (Laravel 12 + PHP 8.2 + MySQL)
**Target Database Name:** `marketplace`
**Database Engine:** InnoDB, `utf8mb4_unicode_ci`
**Total Tables:** 34

---

## 1. Table Summary & Existing Record Counts

| Table Name | Existing Rows | Primary Key | Description / Purpose |
|---|---|---|---|
| `app_features` | 13 | `id` | Feature flags and capabilities for mobile app |
| `app_settings` | 3 | `id` | Mobile app configurations and versions |
| `business_listings` | 4 | `id` | Local business and educational institute directory listings |
| `cache` | 0 | `id` | System infrastructure table |
| `cache_locks` | 0 | `id` | System infrastructure table |
| `categories` | 10 | `id` | Universal taxonomy categories across the marketplace |
| `certificates` | 2 | `id` | Issued course completion and achievement certificates |
| `conversations` | 96 | `id` | Direct messaging threads between users, sellers, and admin |
| `courses` | 15 | `id` | Digital courses with pricing, curriculum, status, level |
| `course_contents` | 0 | `id` | Course sections, lectures, video links, duration |
| `discount_coupons` | 24 | `id` | Promo discount codes and voucher rules |
| `failed_jobs` | 0 | `id` | System infrastructure table |
| `jobs` | 0 | `id` | System infrastructure table |
| `job_batches` | 0 | `id` | System infrastructure table |
| `leads` | 10 | `id` | Inquiries and lead capture for businesses and services |
| `messages` | 136 | `id` | Individual messages in chat conversations |
| `migrations` | 20 | `id` | System infrastructure table |
| `orders` | 30 | `id` | E-commerce order transactions, payments, and fulfillment |
| `password_reset_tokens` | 0 | `id` | System infrastructure table |
| `platform_notifications` | 126 | `id` | User and seller system push notifications |
| `posts` | 10 | `id` | Marketplace blog articles and updates |
| `post_comments` | 2 | `id` | Reader comments on blog articles |
| `products` | 16 | `id` | Digital assets and physical store products |
| `promotions` | 40 | `id` | Featured banner ads, sponsor slots, and home campaigns |
| `reviews` | 10 | `id` | Ratings and verified reviews for courses, services, and products |
| `sellers` | 8 | `id` | Verified seller accounts with unique seller_code and status |
| `seller_business_details` | 8 | `id` | Full business, legal, banking, and tax profiles for sellers |
| `seo_settings` | 1 | `id` | Meta tags, OG data, and site-wide SEO configs |
| `services` | 4 | `id` | Freelance services & gigs with tier pricing & delivery times |
| `sessions` | 0 | `id` | System infrastructure table |
| `support_tickets` | 10 | `id` | Customer and seller helpdesk support tickets |
| `support_ticket_messages` | 12 | `id` | Replies and attachments on support tickets |
| `users` | 10 | `id` | Unified platform users (Customer, Seller, Admin, Super Admin) |
| `website_pages` | 28 | `id` | CMS static pages (About, Terms, Privacy) |

---

## 2. Detailed Schema of Core Tables

### `users`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `name` | `varchar(255)` | No | *none* | - |  |
| `email` | `varchar(255)` | No | *none* | `UNI` |  |
| `avatar` | `varchar(255)` | Yes | `NULL` | - |  |
| `phone` | `varchar(255)` | Yes | `NULL` | - |  |
| `role` | `varchar(255)` | No | `'seller'` | - |  |
| `email_verified_at` | `timestamp` | Yes | `NULL` | - |  |
| `password` | `varchar(255)` | No | *none* | - |  |
| `remember_token` | `varchar(100)` | Yes | `NULL` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `sellers`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `user_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `seller_code` | `varchar(50)` | No | *none* | `UNI` |  |
| `account_type` | `varchar(50)` | No | *none* | - |  |
| `seller_status` | `varchar(30)` | No | `'Pending Approval'` | `MUL` |  |
| `verification_status` | `varchar(30)` | No | `'Not Verified'` | `MUL` |  |
| `registration_date` | `timestamp` | No | `current_timestamp()` | - |  |
| `approved_at` | `timestamp` | Yes | `NULL` | - |  |
| `approved_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `rejection_reason` | `text` | Yes | `NULL` | - |  |
| `rejected_at` | `timestamp` | Yes | `NULL` | - |  |
| `rejected_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `suspended_at` | `timestamp` | Yes | `NULL` | - |  |
| `suspended_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `seller_business_details`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `business_name` | `varchar(255)` | Yes | `NULL` | - |  |
| `business_email` | `varchar(255)` | Yes | `NULL` | - |  |
| `business_phone` | `varchar(30)` | Yes | `NULL` | - |  |
| `business_category` | `varchar(100)` | Yes | `NULL` | - |  |
| `business_description` | `text` | Yes | `NULL` | - |  |
| `website` | `varchar(255)` | Yes | `NULL` | - |  |
| `address` | `text` | Yes | `NULL` | - |  |
| `city` | `varchar(100)` | Yes | `NULL` | - |  |
| `state` | `varchar(100)` | Yes | `NULL` | - |  |
| `country` | `varchar(100)` | Yes | `'India'` | - |  |
| `pincode` | `varchar(20)` | Yes | `NULL` | - |  |
| `logo` | `varchar(255)` | Yes | `NULL` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `courses`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `title` | `varchar(255)` | No | *none* | - |  |
| `slug` | `varchar(255)` | Yes | `NULL` | - |  |
| `category` | `varchar(255)` | No | `'Digital Marketing'` | - |  |
| `language` | `varchar(255)` | No | `'Hindi'` | - |  |
| `level` | `varchar(255)` | No | `'Beginner'` | - |  |
| `short_description` | `text` | Yes | `NULL` | - |  |
| `description` | `longtext` | Yes | `NULL` | - |  |
| `thumbnail` | `varchar(255)` | Yes | `NULL` | - |  |
| `is_free` | `tinyint(1)` | No | `0` | - |  |
| `price` | `decimal(10,2)` | No | `0.00` | - |  |
| `discount_price` | `decimal(10,2)` | Yes | `NULL` | - |  |
| `access_type` | `varchar(255)` | No | `'Lifetime Access'` | - |  |
| `certificate_included` | `tinyint(1)` | No | `1` | - |  |
| `qa_enabled` | `tinyint(1)` | No | `1` | - |  |
| `status` | `varchar(30)` | No | `'pending'` | - |  |
| `rejection_reason` | `text` | Yes | `NULL` | - |  |
| `approved_at` | `timestamp` | Yes | `NULL` | - |  |
| `approved_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `course_contents`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `course_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `section_title` | `varchar(255)` | No | `'1. Introduction'` | - |  |
| `lecture_title` | `varchar(255)` | No | *none* | - |  |
| `duration` | `varchar(255)` | Yes | `NULL` | - |  |
| `video_url` | `varchar(255)` | Yes | `NULL` | - |  |
| `sort_order` | `int(11)` | No | `1` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `services`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `title` | `varchar(255)` | No | *none* | - |  |
| `slug` | `varchar(255)` | Yes | `NULL` | - |  |
| `category` | `varchar(255)` | No | `'Graphic Design'` | - |  |
| `short_description` | `text` | Yes | `NULL` | - |  |
| `description` | `longtext` | Yes | `NULL` | - |  |
| `tags` | `varchar(255)` | Yes | `NULL` | - |  |
| `delivery_days` | `int(11)` | No | `3` | - |  |
| `package_name` | `varchar(255)` | No | `'Basic'` | - |  |
| `price` | `decimal(10,2)` | No | `0.00` | - |  |
| `package_features` | `text` | Yes | `NULL` | - |  |
| `buyer_requirements` | `text` | Yes | `NULL` | - |  |
| `thumbnail` | `varchar(255)` | Yes | `NULL` | - |  |
| `status` | `varchar(30)` | No | `'pending'` | - |  |
| `rejection_reason` | `text` | Yes | `NULL` | - |  |
| `approved_at` | `timestamp` | Yes | `NULL` | - |  |
| `approved_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `products`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `title` | `varchar(255)` | No | *none* | - |  |
| `slug` | `varchar(255)` | Yes | `NULL` | - |  |
| `category` | `varchar(255)` | No | `'Digital Assets & Tools'` | - |  |
| `product_type` | `varchar(255)` | No | `'Digital'` | - |  |
| `description` | `text` | Yes | `NULL` | - |  |
| `sku` | `varchar(255)` | Yes | `NULL` | - |  |
| `mrp` | `decimal(10,2)` | No | `0.00` | - |  |
| `price` | `decimal(10,2)` | No | `0.00` | - |  |
| `stock_quantity` | `int(11)` | No | `100` | - |  |
| `weight_grams` | `int(11)` | Yes | `NULL` | - |  |
| `shipping_details` | `varchar(255)` | Yes | `NULL` | - |  |
| `thumbnail` | `varchar(255)` | Yes | `NULL` | - |  |
| `status` | `varchar(30)` | No | `'pending'` | - |  |
| `rejection_reason` | `text` | Yes | `NULL` | - |  |
| `approved_at` | `timestamp` | Yes | `NULL` | - |  |
| `approved_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `business_listings`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `business_name` | `varchar(255)` | No | *none* | - |  |
| `slug` | `varchar(255)` | Yes | `NULL` | - |  |
| `category` | `varchar(255)` | No | `'Educational Institute'` | - |  |
| `listing_type` | `varchar(100)` | Yes | `NULL` | - |  |
| `sub_category` | `varchar(100)` | Yes | `NULL` | - |  |
| `established_year` | `varchar(20)` | Yes | `NULL` | - |  |
| `employees_count` | `varchar(50)` | Yes | `NULL` | - |  |
| `tagline` | `varchar(255)` | Yes | `NULL` | - |  |
| `description` | `longtext` | Yes | `NULL` | - |  |
| `features` | `longtext` | Yes | `NULL` | - |  |
| `phone` | `varchar(255)` | Yes | `NULL` | - |  |
| `whatsapp_number` | `varchar(50)` | Yes | `NULL` | - |  |
| `email` | `varchar(255)` | Yes | `NULL` | - |  |
| `website` | `varchar(255)` | Yes | `NULL` | - |  |
| `address` | `text` | Yes | `NULL` | - |  |
| `city` | `varchar(255)` | Yes | `NULL` | - |  |
| `state` | `varchar(255)` | Yes | `NULL` | - |  |
| `pincode` | `varchar(10)` | Yes | `NULL` | - |  |
| `map_location` | `varchar(255)` | Yes | `NULL` | - |  |
| `plan_name` | `varchar(50)` | No | `'Premium Listing'` | - |  |
| `plan_price` | `decimal(10,2)` | No | `1499.00` | - |  |
| `add_ons` | `longtext` | Yes | `NULL` | - |  |
| `logo` | `varchar(255)` | Yes | `NULL` | - |  |
| `cover_image` | `varchar(255)` | Yes | `NULL` | - |  |
| `video_url` | `varchar(255)` | Yes | `NULL` | - |  |
| `status` | `varchar(30)` | No | `'pending'` | - |  |
| `rejection_reason` | `text` | Yes | `NULL` | - |  |
| `approved_at` | `timestamp` | Yes | `NULL` | - |  |
| `approved_by` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `orders`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `seller_id` | `bigint(20) unsigned` | No | *none* | `MUL` |  |
| `order_number` | `varchar(255)` | No | *none* | `UNI` |  |
| `customer_name` | `varchar(255)` | No | *none* | - |  |
| `customer_city` | `varchar(255)` | Yes | `NULL` | - |  |
| `customer_email` | `varchar(255)` | Yes | `NULL` | - |  |
| `customer_phone` | `varchar(255)` | Yes | `NULL` | - |  |
| `customer_avatar` | `varchar(255)` | Yes | `NULL` | - |  |
| `order_type` | `varchar(255)` | No | *none* | - |  |
| `item_title` | `varchar(255)` | No | *none* | - |  |
| `item_subtext` | `varchar(255)` | Yes | `NULL` | - |  |
| `item_thumbnail` | `varchar(255)` | Yes | `NULL` | - |  |
| `amount` | `decimal(10,2)` | No | `0.00` | - |  |
| `subtotal` | `decimal(10,2)` | No | `0.00` | - |  |
| `discount` | `decimal(10,2)` | No | `0.00` | - |  |
| `status` | `varchar(30)` | No | `'completed'` | - |  |
| `placed_at` | `timestamp` | Yes | `NULL` | - |  |
| `timeline` | `longtext` | Yes | `NULL` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `reviews`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `user_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `user_name` | `varchar(255)` | No | *none* | - |  |
| `user_email` | `varchar(255)` | Yes | `NULL` | - |  |
| `user_city` | `varchar(255)` | Yes | `NULL` | - |  |
| `user_avatar` | `varchar(255)` | Yes | `NULL` | - |  |
| `rating` | `decimal(2,1)` | No | `5.0` | - |  |
| `review_text` | `text` | No | *none* | - |  |
| `review_type` | `varchar(255)` | No | `'Course'` | - |  |
| `item_id` | `bigint(20) unsigned` | Yes | `NULL` | - |  |
| `item_title` | `varchar(255)` | No | *none* | - |  |
| `item_thumbnail` | `varchar(255)` | Yes | `NULL` | - |  |
| `seller_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `seller_name` | `varchar(255)` | Yes | `NULL` | - |  |
| `category` | `varchar(255)` | Yes | `NULL` | - |  |
| `order_id` | `varchar(255)` | Yes | `NULL` | - |  |
| `enrolled_on` | `date` | Yes | `NULL` | - |  |
| `completed_on` | `date` | Yes | `NULL` | - |  |
| `photos` | `longtext` | Yes | `NULL` | - |  |
| `status` | `varchar(255)` | No | `'Approved'` | - |  |
| `helpful_upvotes` | `int(11)` | No | `0` | - |  |
| `helpful_downvotes` | `int(11)` | No | `0` | - |  |
| `admin_notes` | `text` | Yes | `NULL` | - |  |
| `is_featured` | `tinyint(1)` | No | `0` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `leads`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `name` | `varchar(255)` | No | *none* | - |  |
| `phone` | `varchar(255)` | No | *none* | - |  |
| `email` | `varchar(255)` | Yes | `NULL` | - |  |
| `avatar` | `varchar(255)` | Yes | `NULL` | - |  |
| `city` | `varchar(255)` | No | `'Ahmedabad, Gujarat'` | - |  |
| `source` | `varchar(255)` | No | `'Meta Ads'` | - |  |
| `campaign` | `varchar(255)` | No | `'Institute ERP'` | - |  |
| `platform` | `varchar(255)` | No | `'Website'` | - |  |
| `status` | `varchar(255)` | No | `'New'` | - |  |
| `assigned_to` | `varchar(255)` | Yes | `NULL` | - |  |
| `next_follow_up` | `date` | Yes | `NULL` | - |  |
| `interested_in` | `varchar(255)` | Yes | `NULL` | - |  |
| `budget` | `varchar(255)` | Yes | `NULL` | - |  |
| `remarks` | `text` | Yes | `NULL` | - |  |
| `activities` | `longtext` | Yes | `NULL` | - |  |
| `notes` | `longtext` | Yes | `NULL` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `categories`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `name` | `varchar(255)` | No | *none* | - |  |
| `slug` | `varchar(255)` | No | *none* | `UNI` |  |
| `count` | `int(11)` | No | `0` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

### `certificates`

| Column | Type | Nullable | Default | Key | Notes |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | No | *none* | `PRI` | auto_increment |
| `certificate_no` | `varchar(64)` | No | *none* | `UNI` |  |
| `student_id` | `varchar(64)` | Yes | `NULL` | - |  |
| `student_name` | `varchar(255)` | No | *none* | - |  |
| `course_title` | `varchar(255)` | No | *none* | - |  |
| `course_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `seller_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `user_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `order_id` | `bigint(20) unsigned` | Yes | `NULL` | `MUL` |  |
| `duration` | `varchar(255)` | No | `'6 Months'` | - |  |
| `start_date` | `varchar(255)` | No | `'15 Apr 2026'` | - |  |
| `completion_date` | `varchar(255)` | No | `'15 Oct 2026'` | - |  |
| `instructor_name` | `varchar(255)` | No | `'Rajesh Sharma'` | - |  |
| `instructor_title` | `varchar(255)` | No | `'Course Instructor'` | - |  |
| `instructor_signature` | `varchar(255)` | Yes | `NULL` | - |  |
| `signatory_name` | `varchar(255)` | No | `'Dr. Neha Mehta'` | - |  |
| `signatory_title` | `varchar(255)` | No | `'Authorized Signatory'` | - |  |
| `institute_name` | `varchar(255)` | No | `'BrightLearn Institute'` | - |  |
| `signatory_signature` | `varchar(255)` | Yes | `NULL` | - |  |
| `is_verified` | `tinyint(1)` | No | `1` | - |  |
| `created_at` | `timestamp` | Yes | `NULL` | - |  |
| `updated_at` | `timestamp` | Yes | `NULL` | - |  |

