# Table Mapping Report: Legacy Database (`digitxix_elm`) to New Platform

This document establishes the table-by-table classification, architectural mapping, and migration decision for all tables in the legacy database.

---

## 1. Table Classification Summary

Every table from `digitxix_elm` (308 tables total) has been evaluated and categorized according to the project specifications:

| Classification | Meaning | Table Count | Action |
|---|---|---|---|
| **A. EXACT MATCH** | Same purpose & identical structure | 0 | Direct migration with key translation |
| **B. PARTIAL MATCH** | Same purpose, differing column names/types | 14 | Column transformation & field mapping |
| **C. STRUCTURE MISMATCH** | Same business entity, different relational model | 8 | Multi-table split/merge transformations |
| **D. NO MATCH (ARCHIVE)** | Legacy offline coaching ERP modules not in new marketplace | 272 | Preserved in legacy backup/archive schema |
| **E. DUPLICATE / CONFLICT** | Old records that may collide with new trial records | Overlaps in B & C | Email & business deduplication strategy |
| **F. OBSOLETE** | Empty tables, legacy cache, temporary session tables | 14 | Excluded from migration |

---

## 2. Core Business Entity Mappings

### 2.1 Users & Authentication (Customers & Admins)

| Source Table (Old) | Rows | Target Table (New) | Current New Rows | Classification | Migration Decision & Strategy |
|---|---|---|---|---|---|
| `dc_elm_users` | 46 | `users` | 10 | **B & E (Partial + Conflict)** | Migrate as `role = 'customer'`. Deduplicate on `email` and `phone`. Convert plaintext passwords to secure Bcrypt hashes. Preserve registration dates. |
| `dc_admin` | 1 | `users` | 1 | **B & E (Partial + Conflict)** | Compare with existing `superadmin@gmail.com`. If new admin account exists, do not overwrite. If unique staff member, migrate as `role = 'admin'`. |
| `reseller_users` | 0 | `users` | 10 | **F (Obsolete)** | Empty table (0 records). Skip. |

---

### 2.2 Sellers & Educators (Tutors & Institutes)

In the new platform, a seller is represented by a relational triad:
1. `users` (login identity & contact details)
2. `sellers` (verification status, account type, seller code)
3. `seller_business_details` (business info, tax/banking, address)
And optionally:
4. `business_listings` (for institutes/schools with directory storefronts)

| Source Table (Old) | Rows | Target Tables (New) | Classification | Migration Decision & Strategy |
|---|---|---|---|---|
| `dc_elearn_tutor` | 74 | `users` + `sellers` + `seller_business_details` | **C (Structure Mismatch)** | **Individual Educator Migration:**<br>1. Create `users` record (`role = 'seller'`).<br>2. Create `sellers` record (`account_type = 'individual'`, status mapped from old `status`).<br>3. Create `seller_business_details` (`business_name = company_name ?: name`, banking, bio, city, state). |
| `dc_affiliate` + `dc_affiliate_account` | 285 | `users` + `sellers` + `seller_business_details` + `business_listings` | **C & E (Mismatch + Duplicate)** | **Institute / School Partner Migration:**<br>1. Extract credentials from `dc_affiliate_account` / `dc_affiliate.email`.<br>2. Create `users` (`role = 'seller'`).<br>3. Create `sellers` (`account_type = 'institute'`).<br>4. Create `seller_business_details` (`business_name = school_name`, address, city, state).<br>5. Create `business_listings` (directory storefront with description, category, address).<br>*Conflict Check:* Check against existing trial sellers (e.g. `VCEC - Vinayak`). |

---

### 2.3 Courses & Curriculum Content

| Source Table (Old) | Rows | Target Table (New) | Current New Rows | Classification | Migration Decision & Strategy |
|---|---|---|---|---|---|
| `dc_elearn_course` | 71 | `courses` | 15 | **B (Partial Match)** | Map `tutor_id` to new `seller_id` via ID map. Map `course_name` → `title`, `course_desc` → `description`, prices, thumbnails, and status. |
| `dc_elearn_course_curriculam` | 92 | `course_contents` | 0 | **C (Structure Mismatch)** | Represents course sections/chapters. Map `course_id` to new course ID. Store `title` as `section_title`. |
| `dc_elearn_course_video` | 13 | `course_contents` | 0 | **C (Structure Mismatch)** | Merge with course curriculum to populate `lecture_title`, `video_url`, and `duration`. |
| `dc_elearn_couse_faq` | 36 | `courses.description` (appended) | - | **C (Structure Mismatch)** | Append structured FAQ blocks into course long description or QA module. |
| `dc_affiliate_institute_course` | 36 | `courses` | 15 | **B (Partial Match)** | Offline/Institute courses offered by affiliates. Migrate linked to the affiliate's seller ID. |

---

### 2.4 Leads & Enquiries

| Source Table (Old) | Rows | Target Table (New) | Current New Rows | Classification | Migration Decision & Strategy |
|---|---|---|---|---|---|
| `app_program_enquiries` | 740 | `leads` | 10 | **B (Partial Match)** | Map `affiliate_id` to new `seller_id`. Map `name`, `email`, `phone`, `message`, `source`, `status` (`pending`, `contacted`, `converted`). |
| `dc_inquiry` | 4 | `leads` | 10 | **B (Partial Match)** | Course-specific student leads. Map `tutor_id` to new `seller_id`, course title, student name, email, contact. |
| `dc_contactus_inquiry` | 1 | `support_tickets` / `leads` | 10 | **B (Partial Match)** | Platform-level contact enquiries. |

---

### 2.5 Orders & Financial Transactions

| Source Table (Old) | Rows | Target Table (New) | Current New Rows | Classification | Migration Decision & Strategy |
|---|---|---|---|---|---|
| `dc_ecom_order` | 1 | `orders` | 30 | **B (Partial Match)** | Map user ID, item ID, total amount, status (`completed`), payment gateway reference. |
| `dc_elearn_transaction` | 3 | `orders` | 30 | **B (Partial Match)** | Map student course purchase transactions. |
| `dc_elearn_tutor_transaction` | 4 | `orders` | 30 | **B (Partial Match)** | Tutor payout / earnings transactions. |
| `dc_affiliate_package_transaction` | 2 | `orders` | 30 | **B (Partial Match)** | Institutional package membership purchases. |

---

### 2.6 Reviews, Categories & Media

| Source Table (Old) | Rows | Target Table (New) | Current New Rows | Classification | Migration Decision & Strategy |
|---|---|---|---|---|---|
| `dc_elearn_reviews` | 1 | `reviews` | 10 | **B (Partial Match)** | Map review text, rating (1-5), user ID, and target course ID. |
| `dc_elm_review` | 1 | `reviews` | 10 | **B (Partial Match)** | Platform rating and review. |
| `dc_affiliate_gallery` | 46 | `business_listings.gallery` | - | **C (Structure Mismatch)** | In the old system, gallery photos were stored as individual rows. In the new system, `business_listings.gallery` is a JSON array of image URLs. Aggregate rows per `affiliate_id` into a JSON array. |
| `app_program_affiliate_blogs` | 7 | `posts` | 10 | **B (Partial Match)** | Map title, slug, content, banner image, author, publication status. |
| `dc_elearn_categories` | 1 | `categories` | 10 | **B (Partial Match)** | Map taxonomy categories and subcategories. |
| `app_program_affiliate_student_certificate` | 6 | `certificates` | 2 | **B (Partial Match)** | Map certificate title, student name, issue date, credential ID. |

---

## 3. Unmatched Tables (Legacy Offline Coaching ERP - Category D)

The following tables (approx. 272 tables) formed the internal ERP for offline coaching classes (student attendance, exam marks, timetables, batch suspension, local expenses, ID cards):
- `app_program_present_student` (727 rows)
- `app_program_quiz_response` (206 rows)
- `app_program_affiliate_fee` (203 rows)
- `affiliate_offline_student_marks` (31 rows)
- `app_program_expenses` (19 rows)
- `app_program_incomes` (8 rows)
- `marksheet_subject_marks` (11 rows)
- `student_batches`, `student_batch_attendance`, `timetables`

**Migration Decision for Category D:**
These tables do NOT belong in the online marketplace schema (`marketplace`), as forcing offline attendance and exam marks into an e-commerce catalog would corrupt application integrity.
**Preservation Plan:** They will be safely preserved in an isolated legacy archive database (`digitxix_elm_archive`), ensuring 0% data loss while keeping the active marketplace database clean and compliant with Laravel conventions.

