# Migration Risks & Mitigation Strategy

This document identifies potential technical, operational, and data risks associated with migrating `digitxix_elm` to the new Digital Class Marketplace, along with concrete mitigation strategies.

---

## 1. Identified Risks and Mitigations

### Risk 1: Unhashed / Incompatible Passwords
- **Description:** In `dc_elm_users` and `dc_admin`, passwords were stored as plaintext or legacy hashes (e.g. `'12345'`, `'sakshi123'`). Storing plaintext in Laravel's `users` table would cause login failures (as Laravel uses `Hash::check()`) and violates data security.
- **Mitigation:**
  - All legacy passwords will be automatically re-hashed with `Hash::make()` (Bcrypt with work factor 12) during migration.
  - Accounts with blank passwords will be assigned a random secure token with a password-reset requirement on first login.

---

### Risk 2: Primary Key & Foreign Key Collisions
- **Description:** Both databases use auto-increment integers starting from 1. Directly inserting `dc_elm_users.id = 1` or `dc_elearn_course.id = 1` would overwrite or conflict with existing trial records (e.g. existing courses 1-15, users 1-20).
- **Mitigation:**
  - Strict ID decoupling: The migration engine will allow the new database to allocate fresh, sequential auto-increment IDs.
  - Every transition is tracked in `migration_id_mappings` (`entity_type`, `old_id`, `new_id`).
  - All foreign key relationships are rewritten on-the-fly using mapped IDs.

---

### Risk 3: Character Encoding & Malformed Strings
- **Description:** The legacy SQL contains Windows carriage returns (`\r\n`), HTML entities, and mixed collations (`utf8_unicode_ci`, `utf8mb4`).
- **Mitigation:**
  - Run UTF-8 sanitation on all string attributes (`mb_convert_encoding()`).
  - Strip redundant carriage returns in address and description fields while preserving paragraph formatting.

---

### Risk 4: Media, Documents & External URLs
- **Description:** Legacy image columns contain absolute URLs pointing to `https://dcelm.digitalclassworld.com/storage/app/app_resources/...` or Google User Content URLs. If the old host is unreachable, images may break.
- **Mitigation:**
  - Preserved historical URLs as valid external links without inventing local mock files.
  - If local media directories from the old server are provided in the future, a secondary media-synchronization script will download and map them into `storage/app/public/`.

---

### Risk 5: Memory Exhaustion & Request Timeouts
- **Description:** The SQL file is 165 MB with nearly 1,000,000 lines. Attempting to parse the entire file into memory at once would cause PHP out-of-memory errors (`Allowed memory size exhausted`).
- **Mitigation:**
  - The migration engine uses streaming line-by-line file readers and Laravel batch chunking (`chunk(100)`).
  - Memory consumption remains flat (< 35 MB) regardless of file size.

---

### Risk 6: Accidental Data Destruction on Production
- **Description:** Running queries like `TRUNCATE` or unguided `INSERT` could wipe out existing trial records or crash production.
- **Mitigation:**
  - The migration engine has **NO destructive queries** (`DROP`, `TRUNCATE`, `DELETE` are completely absent).
  - All operations run inside database transactions with rollback capability on critical errors.
  - A mandatory **DRY RUN mode** verifies counts and conflicts before any real database write occurs.

