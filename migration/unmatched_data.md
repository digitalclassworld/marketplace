# Unmatched Data Report & Legacy Preservation Plan

This document identifies all tables, columns, and data points from the legacy database (`digitxix_elm`) that do not have direct equivalents in the new online marketplace platform, explains why they are excluded from the active schema, and outlines their preservation strategy.

---

## 1. Summary of Unmatched Legacy Data

The old `digitxix_elm` database had 308 tables, of which approximately 36 tables represent core marketplace entities (users, tutors, institutes, courses, contents, leads, orders, reviews, categories, blogs, certificates).

The remaining **272 tables** belonged to legacy, offline coaching institute ERP features and internal administration modules:

### Functional Categories of Unmatched Data:

1. **Offline Coaching ERP Student Management:**
   - Tables: `app_program_present_student` (727 rows), `student_batches`, `student_batch_attendance`, `app_program_student_class`, `app_program_student_section`
   - *Reason for Exclusion:* The new platform is an online marketplace for discovering institutes, buying courses, hiring services, and booking products. Offline daily student attendance and class sections are school ERP features, not marketplace catalog entities.

2. **Offline Marksheets, Exams & Quizzes:**
   - Tables: `affiliate_offline_student_marks` (31 rows), `marksheet_subject_marks` (11 rows), `app_program_assigned_exam` (10 rows), `app_program_quiz_response` (206 rows), `app_program_quiz_question` (57 rows)
   - *Reason for Exclusion:* Offline paper exam marks and internal quiz answer logs belong to institutional school records.

3. **Coaching Branch Financial ERP:**
   - Tables: `app_program_affiliate_fee` (203 rows), `app_program_expenses` (19 rows), `app_program_incomes` (8 rows), `app_program_affiliate_account` (22 rows), `app_program_payslip` (1 row)
   - *Reason for Exclusion:* Branch utility expenses, staff tea/water bills, and local cash fee receipts are internal coaching accounting entries. The new marketplace handles seller earnings, escrow payouts, and customer checkout transactions via `orders`.

4. **Internal Staff & Timetables:**
   - Tables: `app_program_present_employee` (16 rows), `app_program_admin_teacher` (4 rows), `app_program_affiliate_employee` (6 rows), `timetables`, `affiliate_holidays`
   - *Reason for Exclusion:* Staff daily punch-in attendance and lecture timetables.

5. **Legacy Web Scraping & Tracking Tables:**
   - Tables: `dc_affiliate_traffic` (174 rows), `dc_elearn_course_view` (62 rows), `affiliate_visitors` (6 rows)
   - *Reason for Exclusion:* Raw IP tracking, old HTTP referrers, and user agents from 2020-2022.

---

## 2. Preservation Guarantee: Zero Data Loss Policy

As required by the project specifications, **no original records will be deleted, truncated, or discarded.**

### The Preservation Mechanism:
1. **Source Backup Preservation:**
   - The original SQL dump (`digitxix_elm.sql`, 164.9 MB) is permanently retained in read-only cold storage.
2. **Dedicated Staging Archive (`digitxix_elm_archive`):**
   - The entire legacy database will be restored into an isolated historical archive database named `digitxix_elm_archive` on the same MySQL server.
   - This database remains permanently accessible for historical lookup, student marksheet verification, and legacy inquiries.
3. **Active Marketplace Cleanliness:**
   - Only validated, transformed, and compatible e-commerce records (sellers, users, courses, curriculum, directory listings, leads, orders) are imported into the active `marketplace` database.
   - This ensures the new Laravel 12 application performs at peak speed with zero bloated or broken relations.

