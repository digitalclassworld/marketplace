# Complete Legacy Database Migration Plan & Architecture

This document presents the implementation roadmap, software architecture, and execution protocol for migrating `digitxix_elm` into the new Digital Class Marketplace.

---

## 1. Migration Architecture & Component Design

The migration engine will be developed as a completely isolated module within the Laravel architecture, adhering strictly to SOLID principles and Laravel conventions.

```
app/
└── Services/
    └── Migration/
        ├── LegacyDatabaseExtractor.php   (Parses & extracts records from old SQL dump / archive DB)
        ├── LegacyDataTransformer.php     (Sanitizes data, hashes passwords, normalizes status)
        ├── EntityMigrators/
        │   ├── UserMigrator.php          (Migrates dc_elm_users & dc_admin)
        │   ├── SellerMigrator.php        (Transforms dc_elearn_tutor & dc_affiliate into sellers)
        │   ├── CourseMigrator.php        (Migrates courses, curricula, and videos)
        │   ├── BusinessListingMigrator.php (Migrates institute storefront listings)
        │   ├── LeadMigrator.php          (Migrates enquiries and student leads)
        │   ├── OrderMigrator.php         (Migrates transactions and orders)
        │   └── ReviewMigrator.php        (Migrates reviews and ratings)
        └── MigrationManager.php          (Coordinates batches, dry-run, logging, idempotency)
```

---

## 2. Tracking & Audit Infrastructure

Before executing data insertion, the migration engine establishes 4 tracking tables in MySQL:

1. **`migration_batches`**: Tracks migration runs, timestamps, execution modes (DRY_RUN vs LIVE), and administrator metadata.
2. **`migration_logs`**: Step-by-step audit logs of every batch processed, record counts, and elapsed times.
3. **`migration_id_mappings`**: Bidirectional translation between old IDs and new IDs.
4. **`migration_exceptions`**: Records that could not be automatically migrated due to validation constraints or missing references, stored for administrator review.

---

## 3. Step-by-Step Data Flow & Transformation Stages

### Stage 1: Customer & Admin Users
- **Source:** `dc_elm_users` (46 rows) + `dc_admin` (1 row)
- **Target:** `users`
- **Actions:**
  - Deduplicate on `LOWER(email)` and `phone`.
  - Re-hash plaintext passwords via `Hash::make()`.
  - Assign `role = 'customer'` for learners and `'admin'` for staff.
  - Record mappings in `migration_id_mappings`.

### Stage 2: Tutors to Individual Sellers
- **Source:** `dc_elearn_tutor` (74 rows)
- **Target:** `users` + `sellers` + `seller_business_details`
- **Actions:**
  - Create `users` record with `role = 'seller'`.
  - Create `sellers` record with `account_type = 'individual'`, auto-generated `seller_code` (e.g. `DC-SELL-000201`), and normalized status (`active`/`suspended`).
  - Create `seller_business_details` with banking details, bio, address, and specialty.

### Stage 3: Institutional Partners & Business Listings
- **Source:** `dc_affiliate` (285 rows) + `dc_affiliate_account` (175 rows)
- **Target:** `users` + `sellers` + `seller_business_details` + `business_listings`
- **Actions:**
  - Deduplicate against existing trial sellers (e.g. VCEC).
  - Create `users` account for the institute owner/admin.
  - Create `sellers` record with `account_type = 'institute'`.
  - Create `seller_business_details` with registered school/institute legal name.
  - Create `business_listings` directory entry with full facilities description, city, address, logo, and cover image.

### Stage 4: Courses & Syllabus Curriculum
- **Source:** `dc_elearn_course` (71 rows) + `curriculam` (92 rows) + `video` (13 rows)
- **Target:** `courses` + `course_contents`
- **Actions:**
  - Look up `seller_id` from Stage 2/3 mapped IDs.
  - Insert `courses` record with title, description, pricing, certification, and level.
  - Insert `course_contents` lectures and sections linked to the new `courses.id`.

### Stage 5: Leads & Inquiries
- **Source:** `app_program_enquiries` (740 rows) + `dc_inquiry` (4 rows)
- **Target:** `leads`
- **Actions:**
  - Map recipient tutor/affiliate to new `seller_id`.
  - Insert lead record with student name, contact, course subject, and inquiry status.

### Stage 6: Orders & Transactions
- **Source:** `dc_ecom_order` + `dc_elearn_transaction` + `dc_affiliate_package_transaction`
- **Target:** `orders`
- **Actions:**
  - Map buyer to new `user_id`, item to new course/service.
  - Insert order records with completed payment status and timestamps.

### Stage 7: Reviews & Ratings
- **Source:** `dc_elearn_reviews` + `dc_elm_review`
- **Target:** `reviews`
- **Actions:**
  - Link verified reviews to new user and course IDs.

---

## 4. Execution Protocol & Safety Gates

1. **Gate 1 — Discovery & Schema Analysis:** Complete (Documented in Reports 1 through 9).
2. **Gate 2 — User Review & Approval:** Present complete findings, mapping blueprints, and risk analysis to the user for formal approval before writing engine code.
3. **Gate 3 — Migration Engine Development:** Construct the modular migration service and Artisan command (`php artisan marketplace:migrate-legacy`).
4. **Gate 4 — Staging Dry-Run:** Execute in `--dry-run` mode against isolated staging databases. Output detailed counts, skipped records, and conflict audits.
5. **Gate 5 — Formal Approval for Live Run:** Present Dry-Run logs to user. Await explicit approval.
6. **Gate 6 — Live Execution:** Execute batch by batch with transaction checkpoints.
7. **Gate 7 — Validation & Test Suite:** Run PHPUnit test suite, verify admin and seller portals, verify storefront browsing.
8. **Gate 8 — Final Report Generation:** Deliver comprehensive post-migration report.

