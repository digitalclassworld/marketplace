# Column Mapping Report: Field Transformations & Data Types

This document specifies the exact column-by-column mapping, data type conversions, default values, and status normalization logic from the old schema to the new schema.

---

## 1. Users Mapping (`dc_elm_users` → `users`)

| Old Column (`dc_elm_users`) | Old Type | New Column (`users`) | New Type | Transformation & Handling Logic |
|---|---|---|---|---|
| `id` | `int(11)` | *(generated new ID)* | `bigint(20)` unsigned | **ID Translation:** Old ID mapped to new ID via `migration_id_mappings`. |
| `username` | `varchar(100)` | `name` | `varchar(255)` | If `username` is empty, fallback to email prefix or contact name. |
| `email` | `varchar(100)` | `email` | `varchar(255)` | Lowercase, trim. Deduplicate against existing users before insert. |
| `contact` | `varchar(15)` | `phone` | `varchar(20)` | Strip non-numeric characters, retain valid 10-12 digit mobile numbers. |
| `profile` | `varchar(255)` | `avatar` | `varchar(255)` | Store avatar URL or relative path. If default placeholder, leave null. |
| `flag` | `varchar(20)` | `profession` | `varchar(100)` | Old values `'Student'` → `'Student / Learner'`, etc. |
| `city` | `varchar(30)` | `city` | `varchar(100)` | Trim string, default to `'Ahmedabad'` if empty. |
| `state` | `varchar(30)` | `state` | `varchar(100)` | Trim string, default to `'Gujarat'` if empty. |
| `password` | `varchar(100)` | `password` | `varchar(255)` | **Security Transformation:** Old plaintext passwords are converted to secure Bcrypt hashes via `Hash::make($oldPassword)`. |
| *(hardcoded)* | - | `role` | `varchar(20)` | Set to `'customer'`. |
| `created_at` | `datetime` | `created_at` | `timestamp` | Preserved as-is. |
| `updated_at` | `datetime` | `updated_at` | `timestamp` | Preserved as-is. |
| `email_verification` | `varchar(20)` | `email_verified_at` | `timestamp` | If old status was active/verified, set to `created_at`, else `null`. |

---

## 2. Tutors to Sellers Mapping (`dc_elearn_tutor` → `users`, `sellers`, `seller_business_details`)

### Target 1: `users`
| Old Column (`dc_elearn_tutor`) | New Column (`users`) | Transformation Logic |
|---|---|---|
| `name` | `name` | Tutor full name. |
| `email` | `email` | Deduplicated login email. |
| `contact` | `phone` | Contact phone number. |
| `password` | `password` | Bcrypt hashed. |
| `profile` | `avatar` | Profile image URL. |
| `city` | `city` | City of residence. |
| `state` | `state` | State of residence. |
| *(hardcoded)* | `role` | Set to `'seller'`. |

### Target 2: `sellers`
| Old Column (`dc_elearn_tutor`) | New Column (`sellers`) | Transformation Logic |
|---|---|---|
| *(generated)* | `user_id` | Foreign key referencing the newly created `users.id`. |
| *(generated)* | `seller_code` | Auto-generated standard format: `DC-SELL-000` + sequential padded number. |
| *(hardcoded)* | `account_type` | `'individual'` (educator / tutor). |
| `status` | `seller_status` | `'active'` → `'active'`, `'not_active'` → `'suspended'`. |
| `verified` | `verification_status` | `'yes'` → `'verified'`, `'no'` → `'pending'`. |
| `created_at` | `registration_date` | Date tutor registered on platform. |
| `created_at` | `approved_at` | Set to registration date if verified = 'yes'. |

### Target 3: `seller_business_details`
| Old Column (`dc_elearn_tutor`) | New Column (`seller_business_details`) | Transformation Logic |
|---|---|---|
| *(generated)* | `seller_id` | Foreign key referencing new `sellers.id`. |
| `company_name` ?: `name` | `business_name` | Educator / academy display name. |
| `expert_category` | `business_type` | Professional specialization. |
| `about_self` | `bio` | Bio and background summary. |
| `website` | `website` | Personal or academy website link. |
| `city` | `city` | City. |
| `state` | `state` | State. |
| `pincode` | `pincode` | Postal code. |
| `address` | `address` | Full address. |
| `bankname` | `bank_name` | Payout bank name. |
| `acname` | `bank_account_name` | Payout account holder name. |
| `acno` | `bank_account_number` | Bank account number. |
| `ifsc` | `bank_ifsc` | Bank IFSC code. |

---

## 3. Affiliates to Business Listings Mapping (`dc_affiliate` → `business_listings` + `sellers`)

| Old Column (`dc_affiliate`) | Target Table & Column | Transformation Logic |
|---|---|---|
| `school_name` | `business_listings.business_name` & `seller_business_details.business_name` | Official institute or business title. |
| `slug` (or generated) | `business_listings.slug` | URL slug generated via `Str::slug($school_name)`. |
| `coaching_category` | `business_listings.category` | Category e.g. "Educational Institute", "Coaching Center". |
| `short_description` | `business_listings.tagline` | Short summary / motto. |
| `full_description` | `business_listings.description` | Detailed profile and facility description. |
| `email` | `business_listings.email` & `users.email` | Contact email. |
| `contact` | `business_listings.phone` & `users.phone` | Contact telephone / mobile. |
| `website_url` | `business_listings.website` | Official website URL. |
| `address` | `business_listings.address` | Physical street address. |
| `city` | `business_listings.city` | City location. |
| `state` | `business_listings.state` | State location. |
| `pincode` | `business_listings.pincode` | Postal code. |
| `logo` | `business_listings.logo` | Storefront logo image URL. |
| `cover_image` | `business_listings.cover_image` | Header banner image URL. |
| `status` | `business_listings.status` | `'active'` → `'approved'`, `'pending'` → `'pending'`. |
| `created_at` | `business_listings.created_at` | Historical listing date. |

---

## 4. Courses Mapping (`dc_elearn_course` → `courses`)

| Old Column (`dc_elearn_course`) | New Column (`courses`) | Transformation Logic |
|---|---|---|
| `tutor_id` | `seller_id` | Look up mapped new `seller_id` from `dc_elearn_tutor.id`. |
| `course_name` | `title` | Course title. |
| *(generated)* | `slug` | `Str::slug($course_name)`. |
| `category_id` | `category` | Mapped category name (e.g., 'Software & Tech', 'Academics'). |
| `course_language` | `language` | Standardized language (e.g., 'Hindi', 'English', 'Gujarati'). |
| `skill_level` | `level` | Normalized to `'Beginner'`, `'Intermediate'`, or `'Advanced'`. |
| `short_desc` | `short_description` | Concise summary. |
| `course_desc` | `description` | Full syllabus & description. |
| `course_thumbnail` | `thumbnail` | Cover thumbnail URL. |
| `course_price` | `price` | Cast numeric decimal(10,2). If 0, mark `is_free = true`. |
| `course_final_amount` | `discount_price` | Special offer / discount price. |
| `course_certification` | `certificate_included` | Boolean: `'Yes'` → `true`, else `false`. |
| `is_featured` | `is_featured` | Boolean: `'1'` / `'yes'` → `true`, else `false`. |
| `status` | `status` | `'active'` → `'approved'`, `'not_active'` → `'pending'`. |
| `created_at` | `created_at` | Timestamp. |

---

## 5. Course Curriculum & Videos (`dc_elearn_course_curriculam` + `video` → `course_contents`)

| Old Table & Column | New Column (`course_contents`) | Transformation Logic |
|---|---|---|
| `curriculam.course_id` | `course_id` | Mapped new `course_id`. |
| `curriculam.title` | `section_title` | Section name (e.g. "Chapter 1: Foundations"). |
| `video.lesson_name` | `lecture_title` | Specific lecture name (or default to section title). |
| `video.duration` | `duration` | Formatted string (e.g. "15:40"). |
| `video.video_link` | `video_url` | Video stream or playback URL. |
| *(sequential)* | `sort_order` | Integer order (1, 2, 3...). |

---

## 6. Leads & Inquiries (`app_program_enquiries` & `dc_inquiry` → `leads`)

| Old Table & Column | New Column (`leads`) | Transformation Logic |
|---|---|---|
| `name` | `name` | Inquirer full name. |
| `email` | `email` | Inquirer email. |
| `phone` / `contact` | `phone` | Inquirer mobile number. |
| `subject` / `course_name` | `subject` | Course or service inquired about. |
| `message` | `message` | Inquiry remarks / message. |
| `affiliate_id` / `tutor_id` | `seller_id` | Mapped recipient seller ID (or null for platform lead). |
| `source` | `source` | Source tag (e.g. 'Web Search', 'Marketplace'). |
| `status` | `status` | Normalized to `'new'`, `'contacted'`, or `'converted'`. |
| `created_at` | `created_at` | Lead timestamp. |

