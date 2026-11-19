# Old Database Schema Analysis (`digitxix_elm`)

**Source File:** `C:\Users\meshw\Downloads\digitxix_elm.sql` (164.90 MB, 975,909 lines)
**Original Database Name:** `digitxix_elm`
**Source Environment:** MySQL 5.7.23-23, PHP 8.1.34, phpMyAdmin 5.2.3
**Default Charset:** `utf8mb4` / `utf8_unicode_ci`
**Total Declared Tables:** 308
**Tables Containing Records:** 269

---

## 1. Executive Summary of Old Database Modules

The `digitxix_elm` database served the legacy Digital Class Educational World system, encompassing multi-branch institute management, online courses (tutors), school directory, affiliate networks, and lead/enquiry generation.

### Functional Groupings of Old Tables:
1. **Users & Authentication (`dc_elm_users`, `dc_admin`, `reseller_users`):** Student, tutor, and staff user records.
2. **Institutional Partners & Affiliates (`dc_affiliate`, `dc_affiliate_account`, `dc_affiliate_*`):** Coaching classes, schools, and business listings (285+ records).
3. **Educators & Tutors (`dc_elearn_tutor`, `dc_elearn_tutor_*`):** Course creators and freelance educators (74+ records).
4. **Courses & Curriculum (`dc_elearn_course`, `dc_elearn_course_curriculam`, `dc_elearn_course_video`, `dc_elearn_couse_faq`):** Course catalog, syllabi, and video links (71+ courses, 92+ curriculum items).
5. **Inquiries & Student Enquiries (`app_program_enquiries`, `dc_inquiry`, `add_user_enquiry`):** Student leads and enquiries (740+ records in `app_program_enquiries`).
6. **Orders & Transactions (`dc_ecom_order`, `dc_elearn_transaction`, `dc_affiliate_transaction`):** Historical order and payment records.
7. **Reviews & Ratings (`dc_elearn_reviews`, `dc_elm_review`):** Course reviews and ratings.
8. **Certificates (`app_program_affiliate_student_certificate`, `app_program_affiliate_bonafide_certificate`):** Issued student certificates.
9. **Legacy/Affiliate ERP Modules (`app_program_*`, `affiliate_*`, `marksheet_*`, `batch_*`):** High school/offline coaching ERP modules (attendance, marks, holidays, timetables) that were specific to offline coaching center management.

---

## 2. Top Active Tables by Record Count

| # | Old Table Name | Row Count | Primary Purpose in Old System |
|---|---|---|---|
| 1 | `app_program_enquiries` | 740 | Student/Client Leads & Inquiries |
| 2 | `app_program_present_student` | 727 | Student ERP / Class Enrollment |
| 3 | `dc_affiliate` | 285 | Institutes / Schools / Business Partners |
| 4 | `app_program_quiz_response` | 206 | Legacy ERP / Operational Data |
| 5 | `app_program_affiliate_fee` | 203 | Legacy ERP / Operational Data |
| 6 | `dc_affiliate_account` | 175 | Affiliate Account Credentials & Banking |
| 7 | `dc_affiliate_traffic` | 174 | Affiliate Referral Traffic Logs |
| 8 | `dc_elearn_course_curriculam` | 92 | Course Syllabus Sections & Chapters |
| 9 | `dc_elearn_tutor` | 74 | Course Instructors & Tutors |
| 10 | `dc_elearn_course` | 71 | E-Learning Course Catalog |
| 11 | `dc_elearn_course_view` | 62 | Course Impression & View Tracking |
| 12 | `app_program_quiz_question` | 57 | Legacy ERP / Operational Data |
| 13 | `dc_affiliate_gallery` | 46 | Business / Institute Photo Gallery |
| 14 | `dc_elm_users` | 46 | Registered Platform Users / Learners |
| 15 | `dc_affiliate_institute_course` | 36 | Legacy ERP / Operational Data |
| 16 | `dc_elearn_couse_faq` | 36 | Course FAQs |
| 17 | `affiliate_offline_student_marks` | 31 | Student ERP / Class Enrollment |
| 18 | `app_program_affiliate_account` | 22 | Legacy ERP / Operational Data |
| 19 | `app_program_expenses` | 19 | Legacy ERP / Operational Data |
| 20 | `dc_elearn_course_include` | 18 | Legacy ERP / Operational Data |
| 21 | `dc_elearn_covering_topics` | 17 | Legacy ERP / Operational Data |
| 22 | `app_program_present_employee` | 16 | Legacy ERP / Operational Data |
| 23 | `app_program_affliliate_course_listing` | 14 | Legacy ERP / Operational Data |
| 24 | `app_program_affiliate_calls` | 13 | Legacy ERP / Operational Data |
| 25 | `dc_elearn_course_video` | 13 | Course Video Lessons & URLs |
| 26 | `dc_elearn_quiz` | 11 | Legacy ERP / Operational Data |
| 27 | `marksheet_subject_marks` | 11 | Legacy ERP / Operational Data |
| 28 | `app_program_assigned_exam` | 10 | Legacy ERP / Operational Data |
| 29 | `affiliate_admission_logs` | 9 | Legacy ERP / Operational Data |
| 30 | `app_program_incomes` | 8 | Legacy ERP / Operational Data |
| 31 | `dc_affiliate_website` | 8 | Legacy ERP / Operational Data |
| 32 | `app_program_affiliate_blogs` | 7 | Legacy ERP / Operational Data |
| 33 | `app_program_quiz_attempt_count` | 7 | Legacy ERP / Operational Data |
| 34 | `affiliate_visitors` | 6 | Legacy ERP / Operational Data |
| 35 | `app_program_affiliate_employee` | 6 | Legacy ERP / Operational Data |
| 36 | `app_program_affiliate_student_certificate` | 6 | Student ERP / Class Enrollment |
| 37 | `dc_elearn_course_demo_video` | 6 | Legacy ERP / Operational Data |
| 38 | `app_program_student_class` | 5 | Student ERP / Class Enrollment |
| 39 | `dc_elm_wallet` | 5 | Legacy ERP / Operational Data |
| 40 | `app_program_admin_teacher` | 4 | Legacy ERP / Operational Data |

---

## 3. Detailed Schema of Core Business Tables

### `dc_elm_users`
```sql
CREATE TABLE `dc_elm_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'https://digitalclassworld.com/e-learning/public/assets/img/ic_profile.PNG',
  `standard` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pincode` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dob` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gender` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tracking_source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `otp_verification` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_verification` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `verification_through` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referallcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flag` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Student',
  `student_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `affiliate_tag_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_affiliate`
```sql
CREATE TABLE `dc_affiliate` (
  `id` int(11) NOT NULL,
  `lister_id` int(11) NOT NULL,
  `school_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `full_description` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pincode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `since` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `board` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_of_school` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coaching_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `coaching_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `total_students` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `facebook_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `instagram_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `youtube_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` text COLLATE utf8_unicode_ci NOT NULL,
  `demo_class_offered` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_known` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_material` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `passout_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `premium` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `affiliate_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `property_verified` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_verified',
  `url_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_index` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noindex',
  `g_indexing` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `g_indexing_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `g_indexing_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_activated` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_affiliate_account`
```sql
CREATE TABLE `dc_affiliate_account` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `business_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `business_address` text COLLATE utf8_unicode_ci NOT NULL,
  `business_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `role_of_business` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dof` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `team_member` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `additional_business_info` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coverimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pincode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `referallcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `facebook_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `linkedin_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `twitter_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `instagram_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `youtube_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `application_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tracking_source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unverified',
  `verified` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `affiliate_package_select` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `school_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `college_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `institute_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `website_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `apps_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `channel_added` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `otp_verification` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `verification_through` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notactive',
  `affiliate_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_elearn_tutor`
```sql
CREATE TABLE `dc_elearn_tutor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expert_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `expert_in` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `about_self` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `language_known` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `education` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'https://digitalclassworld.com/e-learning/public/assets/img/ic_profile.PNG',
  `cover_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pincode` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dob` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `doj` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `imei` text COLLATE utf8_unicode_ci NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `otp_verification` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `verification_through` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `referallcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `acname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bankname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `acno` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ifsc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `flag` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Tutor',
  `tag` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tutor_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Android',
  `tutor_package_select` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tutor_want_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tutor_course_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `tutor_no_of_students` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tracking_source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profile_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unverified',
  `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `verified` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `affiliate_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_elearn_course`
```sql
CREATE TABLE `dc_elearn_course` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `course_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_chapter` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_video` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_hours` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `course_month` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_thumbnail` text COLLATE utf8_unicode_ci NOT NULL,
  `course_self_thumbnail` text COLLATE utf8_unicode_ci,
  `course_language` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_certification` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_price_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_discount` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_final_amount` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_mode` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_video_mode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_listing_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Course',
  `course_selling_for` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_activation_instruction` text COLLATE utf8_unicode_ci,
  `product_link` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `course_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_active',
  `seo_meta_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_meta_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_index` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ci` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `cc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `cct` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `cfaq` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ccv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `cdcv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `cdv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `clv` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `is_recommended` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `is_featured` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `is_trending` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `is_flash` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `tag_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_demo_video_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skill_level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag_font` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `self_thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_placement` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_elearn_course_curriculam`
```sql
CREATE TABLE `dc_elearn_course_curriculam` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_elearn_course_video`
```sql
CREATE TABLE `dc_elearn_course_video` (
  `id` int(11) NOT NULL,
  `chapter_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lesson_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lesson_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `duration` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `video_link` text COLLATE utf8_unicode_ci NOT NULL,
  `course_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `app_program_enquiries`
```sql
CREATE TABLE `app_program_enquiries` (
  `id` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `staff_id` bigint(20) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `enquiry_date` varchar(255) DEFAULT NULL,
  `follow_date` varchar(255) DEFAULT NULL,
  `next_date` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_admission` varchar(10) DEFAULT '0',
  `admission_status` varchar(255) DEFAULT '1',
  `admission_no` varchar(255) DEFAULT NULL,
  `roll_no` varchar(255) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `edu_qualification` varchar(255) DEFAULT NULL,
  `session_name` varchar(50) DEFAULT NULL,
  `transfer_name` varchar(50) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `father_occuption` varchar(255) DEFAULT NULL,
  `admission_date` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `id_proof` varchar(255) DEFAULT NULL,
  `address_proof` varchar(255) DEFAULT NULL,
  `domicile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `g_total_fee` varchar(10) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `total_fee` varchar(255) DEFAULT NULL,
  `transport_fee` varchar(20) DEFAULT NULL,
  `total_fee_without_gst` varchar(50) DEFAULT NULL,
  `gst` varchar(50) DEFAULT NULL,
  `fee_due` varchar(255) DEFAULT NULL,
  `fines` varchar(10) NOT NULL DEFAULT '0',
  `other_amount` varchar(10) NOT NULL DEFAULT '0',
  `fee_date` date DEFAULT NULL,
  `next_due_date` date DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_phone` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_phone` varchar(255) DEFAULT NULL,
  `fee_set` bigint(20) NOT NULL DEFAULT '0',
  `delete_status` int(10) NOT NULL DEFAULT '0',
  `login_email` varchar(50) DEFAULT NULL,
  `login_password` varchar(255) DEFAULT NULL,
  `login_status` int(10) NOT NULL DEFAULT '0',
  `course_status` int(10) NOT NULL DEFAULT '0',
  `direct_admission` varchar(10) NOT NULL DEFAULT '0',
  `library_card_no` varchar(50) DEFAULT NULL,
  `upgrade_status` varchar(10) NOT NULL DEFAULT '0',
  `form_url` text,
  `student_remarks` text,
  `student_adhar_no` varchar(50) DEFAULT NULL,
  `father_adhar_no` varchar(50) DEFAULT NULL,
  `mother_adhar_no` varchar(50) DEFAULT NULL,
  `family_id` varchar(50) DEFAULT NULL,
  `srn_no` varchar(50) DEFAULT NULL,
  `pen_no` varchar(50) DEFAULT NULL,
  `apar_id` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `form_submission_count` int(10) NOT NULL DEFAULT '0',
  `demo_taken` varchar(20) DEFAULT NULL,
  `enquiry_category` varchar(20) DEFAULT NULL,
  `fee_type` varchar(20) DEFAULT NULL,
  `emi_status` varchar(20) DEFAULT NULL,
  `emp_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### `dc_inquiry`
```sql
CREATE TABLE `dc_inquiry` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `course_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `inquiry_at` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New Lead Added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

### `dc_admin`
```sql
CREATE TABLE `dc_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'https://play-lh.googleusercontent.com/DayTZPX5QOvHhkmP59plPT62gEYP7MoWD3CRBE8EJ3bRj_oyhI2pt2S_Trmk1mdVmQ=w144-h144-n-rw',
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'staff',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

