# Relationship Mapping & Foreign Key Dependency Architecture

This document defines how relational dependencies, parent-child links, and key translations are maintained during the database migration.

---

## 1. Relational Dependency Tree & Migration Execution Order

To preserve referential integrity and avoid orphaned records, data must be migrated in strict topological order:

```
[Level 1: Base Identities]
   ├── Legacy Users (`dc_elm_users`) ────────► `users` (Customers)
   └── Legacy Admins (`dc_admin`) ───────────► `users` (Staff / Admins)

[Level 2: Sellers & Partners]
   ├── Legacy Tutors (`dc_elearn_tutor`) ─────► `users` + `sellers` + `seller_business_details`
   └── Legacy Affiliates (`dc_affiliate`) ───► `users` + `sellers` + `seller_business_details`

[Level 3: Storefronts & Catalogs]
   ├── Affiliate Listings ───────────────────► `business_listings` (references `sellers.id`)
   └── Legacy Courses (`dc_elearn_course`) ──► `courses` (references `sellers.id`)

[Level 4: Course Contents]
   └── Curriculum & Videos ──────────────────► `course_contents` (references `courses.id`)

[Level 5: Transactions & Engagement]
   ├── Orders & Payments ────────────────────► `orders` (references `users.id` & item)
   ├── Reviews & Ratings ────────────────────► `reviews` (references `users.id` & `courses.id`)
   └── Leads & Enquiries ────────────────────► `leads` (references `sellers.id`)
```

---

## 2. ID Translation Mechanism (`migration_id_mappings`)

Old integer primary keys from `digitxix_elm` will **never** be copied directly into the new platform's auto-increment IDs. This prevents collisions with existing trial records (`sellers.id` 1-10, `courses.id` 1-15, etc.).

All ID translations will be tracked in a dedicated tracking table:

```sql
CREATE TABLE `migration_id_mappings` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `entity_type` VARCHAR(50) NOT NULL, -- 'user', 'seller_tutor', 'seller_affiliate', 'course', 'listing', 'order'
    `old_id` VARCHAR(100) NOT NULL,
    `new_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_entity_old` (`entity_type`, `old_id`),
    INDEX `idx_new_id` (`entity_type`, `new_id`)
);
```

### Translation Lookups:
1. When inserting a Course from `dc_elearn_course`:
   ```sql
   $oldTutorId = $oldCourse['tutor_id'];
   $newSellerId = MigrationIdMapping::where('entity_type', 'seller_tutor')
       ->where('old_id', $oldTutorId)
       ->value('new_id');
   // Insert into courses with seller_id = $newSellerId
   ```

2. When inserting Course Contents from `dc_elearn_course_curriculam`:
   ```sql
   $oldCourseId = $oldCurriculum['course_id'];
   $newCourseId = MigrationIdMapping::where('entity_type', 'course')
       ->where('old_id', $oldCourseId)
       ->value('new_id');
   // Insert into course_contents with course_id = $newCourseId
   ```

3. When inserting an Order or Review:
   ```sql
   $oldUserId = $oldReview['user_id'];
   $newUserId = MigrationIdMapping::where('entity_type', 'user')
       ->where('old_id', $oldUserId)
       ->value('new_id');
   ```

---

## 3. Orphan Prevention Strategy

If an old record references a parent ID that does not exist in the source or could not be migrated:
1. **Rule:** NEVER insert child records with dummy, guessed, or foreign keys that point to incorrect owners.
2. **Action:** Log the record into `migration_exceptions` table with the missing reference reason.
3. **Review:** Present the orphaned record in the dry-run and final review reports for administrator resolution.

