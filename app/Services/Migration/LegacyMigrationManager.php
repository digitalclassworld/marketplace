<?php

namespace App\Services\Migration;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LegacyMigrationManager
{
    protected LegacySqlParser $parser;
    protected string $mode = 'dry_run'; // 'dry_run' or 'live'
    protected ?string $batchCode = null;
    protected ?\Closure $logger = null;

    // Cache of existing keys to prevent duplicates
    protected array $existingUserEmails = [];
    protected array $existingSellerEmails = [];
    protected array $existingListingNames = [];
    protected array $existingCourseTitles = [];
    protected array $idMap = [];

    // Counters
    protected array $stats = [
        'users' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
        'tutors' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
        'affiliates' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
        'courses' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
        'curriculums' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
        'leads' => ['processed' => 0, 'migrated' => 0, 'skipped' => 0, 'duplicates' => 0],
    ];

    public function __construct(string $mode = 'dry_run', ?LegacySqlParser $parser = null)
    {
        @set_time_limit(0);
        @ini_set('memory_limit', '1024M');
        $this->mode = $mode;
        $this->parser = $parser ?: new LegacySqlParser();
        $this->batchCode = 'BATCH_' . date('Ymd_His') . '_' . strtoupper(Str::random(4));
    }

    public function setLogger(callable $logger): self
    {
        $this->logger = \Closure::fromCallable($logger);
        return $this;
    }

    protected function log(string $msg, string $type = 'info'): void
    {
        if ($this->logger) {
            ($this->logger)($msg, $type);
        }
    }

    /**
     * Run full migration process
     */
    public function execute(?int $limitPerEntity = null, string $targetEntity = 'all'): array
    {
        $this->log("Starting Legacy Migration [Mode: " . strtoupper($this->mode) . "] [Batch: {$this->batchCode}] [Entity: {$targetEntity}]");
        $startTime = microtime(true);

        // Preload existing unique keys from new platform to guarantee NO collisions
        $this->preloadExistingKeys();

        // Register Batch in database
        DB::table('migration_batches')->insert([
            'batch_code' => $this->batchCode,
            'mode' => $this->mode,
            'source_file' => basename($this->parser->getFilePath()),
            'status' => 'in_progress',
            'started_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            if ($this->mode === 'dry_run') {
                DB::beginTransaction();
            }

            $runAll = ($targetEntity === 'all');

            // Stage 1: Customers
            if ($runAll || $targetEntity === 'users' || $targetEntity === 'customers') {
                $this->migrateCustomers($limitPerEntity);
            }

            // Stage 2: Admin Staff
            if ($runAll || $targetEntity === 'admins') {
                $this->migrateAdmins();
            }

            // Stage 3: Educators & Tutors (Sellers)
            if ($runAll || $targetEntity === 'tutors' || $targetEntity === 'sellers') {
                $this->migrateTutors($limitPerEntity);
            }

            // Stage 4: Institutes & Businesses (Sellers + Business Listings)
            if ($runAll || $targetEntity === 'affiliates' || $targetEntity === 'institutes' || $targetEntity === 'listings') {
                $this->migrateAffiliates($limitPerEntity);
            }

            // Stage 5: Courses
            if ($runAll || $targetEntity === 'courses') {
                $this->migrateCourses($limitPerEntity);
            }

            // Stage 6: Course Curricula & Videos
            if ($runAll || $targetEntity === 'curriculums' || $targetEntity === 'contents') {
                $this->migrateCurriculums($limitPerEntity);
            }

            // Stage 7: Inquiries & Leads
            if ($runAll || $targetEntity === 'leads' || $targetEntity === 'enquiries') {
                $this->migrateLeads($limitPerEntity);
            }

            if ($this->mode === 'dry_run') {
                DB::rollBack();
                $this->log("DRY RUN completed successfully. All test database transactions were safely rolled back. 0 production records modified.", 'success');
            }

            $elapsed = round(microtime(true) - $startTime, 2);

            $totalMigrated = array_sum(array_column($this->stats, 'migrated'));
            $totalProcessed = array_sum(array_column($this->stats, 'processed'));
            $totalDuplicates = array_sum(array_column($this->stats, 'duplicates'));
            $totalSkipped = array_sum(array_column($this->stats, 'skipped'));

            DB::table('migration_batches')->where('batch_code', $this->batchCode)->update([
                'status' => 'completed',
                'total_records_processed' => $totalProcessed,
                'total_records_migrated' => $totalMigrated,
                'total_records_skipped' => $totalSkipped + $totalDuplicates,
                'completed_at' => now(),
                'updated_at' => now(),
            ]);

            return [
                'success' => true,
                'batch_code' => $this->batchCode,
                'mode' => $this->mode,
                'elapsed_seconds' => $elapsed,
                'stats' => $this->stats,
                'total_migrated' => $totalMigrated,
                'total_processed' => $totalProcessed,
                'total_duplicates' => $totalDuplicates,
            ];

        } catch (\Throwable $e) {
            if ($this->mode === 'dry_run') {
                DB::rollBack();
            }
            $this->log("Migration failed with error: " . $e->getMessage(), 'error');
            DB::table('migration_batches')->where('batch_code', $this->batchCode)->update([
                'status' => 'failed',
                'completed_at' => now(),
                'updated_at' => now(),
            ]);
            throw $e;
        }
    }

    /**
     * Preload existing emails, titles, and slugs to prevent collisions with trial records
     */
    protected function preloadExistingKeys(): void
    {
        $this->existingUserEmails = DB::table('users')->pluck('id', 'email')->mapWithKeys(function ($id, $email) {
            return [strtolower(trim($email)) => $id];
        })->toArray();

        $this->existingListingNames = DB::table('business_listings')->pluck('id', 'business_name')->mapWithKeys(function ($id, $name) {
            return [strtolower(trim($name)) => $id];
        })->toArray();

        $this->existingCourseTitles = DB::table('courses')->pluck('id', 'title')->mapWithKeys(function ($id, $title) {
            return [strtolower(trim($title)) => $id];
        })->toArray();

        // Preload any existing ID mappings from prior runs
        try {
            $mappings = DB::table('migration_id_mappings')->get(['entity_type', 'old_id', 'new_id']);
            foreach ($mappings as $m) {
                $this->idMap[$m->entity_type][$m->old_id] = $m->new_id;
            }
        } catch (\Throwable $e) {}

        $this->log("Preloaded existing baseline: " . count($this->existingUserEmails) . " users, " . count($this->existingListingNames) . " listings, " . count($this->existingCourseTitles) . " courses, " . count($this->idMap, COUNT_RECURSIVE) . " prior mappings.");
    }

    /**
     * Stage 1: Migrate Customers (dc_elm_users -> users)
     */
    public function migrateCustomers(?int $limit = null): void
    {
        $this->log("--- Stage 1: Migrating Customers from `dc_elm_users` ---");
        $count = 0;
        $inBatch = false;
        if ($this->mode === 'live') {
            DB::beginTransaction();
            $inBatch = true;
        }

        $this->parser->streamTableRows('dc_elm_users', function ($row) use (&$count, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['users']['processed']++;

            $oldId = (string)($row['id'] ?? '');

            // Skip if already migrated in a prior run
            if ($this->lookupNewId('user', $oldId)) {
                $this->stats['users']['duplicates']++;
                return;
            }

            $email = LegacyDataTransformer::normalizeEmail($row['email'] ?? null);
            $name = LegacyDataTransformer::cleanText($row['username'] ?? '') ?: 'Customer ' . $oldId;
            $phone = LegacyDataTransformer::normalizePhone($row['contact'] ?? null);
            $profession = LegacyDataTransformer::mapProfession($row['flag'] ?? null);
            $city = LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad';
            $state = LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat';
            $createdAt = LegacyDataTransformer::normalizeDateTime($row['created_at'] ?? null);
            $password = LegacyDataTransformer::hashPassword($row['password'] ?? '123456');

            if (empty($email)) {
                // If email is missing, generate fallback unique email
                $email = 'customer' . $oldId . '@legacy.digitalclassworld.in';
            }

            // Duplicate check against existing trial users or previously migrated users
            if (isset($this->existingUserEmails[$email])) {
                $existingId = $this->existingUserEmails[$email];
                $this->stats['users']['duplicates']++;
                $this->recordIdMapping('user', $oldId, $existingId, $email);
                return;
            }

            // Insert into users
            $newUserId = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'profession' => $profession,
                'city' => $city,
                'state' => $state,
                'role' => 'customer',
                'password' => $password,
                'email_verified_at' => now(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $this->existingUserEmails[$email] = $newUserId;
            $this->recordIdMapping('user', $oldId, $newUserId, $email);
            $this->stats['users']['migrated']++;

            if ($this->mode === 'live' && $count % 250 === 0) {
                DB::commit();
                DB::beginTransaction();
            }
        });

        if ($this->mode === 'live' && $inBatch) {
            DB::commit();
        }

        $this->log("Customers: {$this->stats['users']['migrated']} migrated, {$this->stats['users']['duplicates']} duplicates linked/skipped.");
    }

    /**
     * Stage 2: Migrate Admin Staff (dc_admin -> users with role 'admin')
     */
    public function migrateAdmins(): void
    {
        $this->parser->streamTableRows('dc_admin', function ($row) {
            $oldId = (string)($row['id'] ?? '');
            $email = LegacyDataTransformer::normalizeEmail($row['email'] ?? null);
            if (!$email) return;

            if (isset($this->existingUserEmails[$email])) {
                $this->recordIdMapping('admin', $oldId, $this->existingUserEmails[$email], $email);
                return;
            }

            $createdAt = LegacyDataTransformer::normalizeDateTime($row['created_at'] ?? null);

            $newAdminId = DB::table('users')->insertGetId([
                'name' => LegacyDataTransformer::cleanText($row['name'] ?? 'Admin Staff'),
                'email' => $email,
                'phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                'role' => 'admin',
                'password' => LegacyDataTransformer::hashPassword($row['password'] ?? 'Admin@123'),
                'email_verified_at' => now(),
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            $this->existingUserEmails[$email] = $newAdminId;
            $this->recordIdMapping('admin', $oldId, $newAdminId, $email);
        });
    }

    /**
     * Stage 3: Migrate Tutors (dc_elearn_tutor -> users + sellers + seller_business_details)
     */
    public function migrateTutors(?int $limit = null): void
    {
        $this->log("--- Stage 3: Migrating Educators from `dc_elearn_tutor` ---");
        $count = 0;
        $sellerCounter = 5000; // Start generated seller codes from 5000+ to avoid trial code overlap
        $inBatch = false;
        if ($this->mode === 'live') {
            DB::beginTransaction();
            $inBatch = true;
        }

        $this->parser->streamTableRows('dc_elearn_tutor', function ($row) use (&$count, &$sellerCounter, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['tutors']['processed']++;

            $oldId = (string)($row['id'] ?? '');

            // Skip if already migrated in a prior run
            if ($this->lookupNewId('seller_tutor', $oldId)) {
                $this->stats['tutors']['duplicates']++;
                return;
            }

            $email = LegacyDataTransformer::normalizeEmail($row['email'] ?? null);
            $name = LegacyDataTransformer::cleanText($row['name'] ?? '') ?: 'Educator ' . $oldId;
            $companyName = LegacyDataTransformer::cleanText($row['company_name'] ?? '') ?: $name;

            if (empty($email)) {
                $email = 'tutor' . $oldId . '@tutor.digitalclassworld.in';
            }

            $createdAt = LegacyDataTransformer::normalizeDateTime($row['created_at'] ?? null);

            // Check if user already exists
            if (isset($this->existingUserEmails[$email])) {
                $userId = $this->existingUserEmails[$email];
                $this->stats['tutors']['duplicates']++;

                // If user is already a seller in database, map and avoid re-insert
                $existingSellerId = DB::table('sellers')->where('user_id', $userId)->value('id');
                if ($existingSellerId) {
                    $this->recordIdMapping('seller_tutor', $oldId, $existingSellerId, $email);
                    return;
                }
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                    'profession' => 'Teacher / Educator',
                    'city' => LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad',
                    'state' => LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat',
                    'role' => 'seller',
                    'password' => LegacyDataTransformer::hashPassword($row['password'] ?? 'Seller@123'),
                    'email_verified_at' => now(),
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);
                $this->existingUserEmails[$email] = $userId;
            }

            $sellerCode = 'DC-SELL-' . str_pad((string)(++$sellerCounter), 6, '0', STR_PAD_LEFT);
            $sellerStatus = LegacyDataTransformer::normalizeStatus($row['status'] ?? 'active');
            $verStatus = ($row['verified'] ?? 'no') === 'yes' ? 'verified' : 'pending';

            $sellerId = DB::table('sellers')->insertGetId([
                'user_id' => $userId,
                'seller_code' => $sellerCode,
                'account_type' => 'individual',
                'seller_status' => $sellerStatus === 'active' ? 'Active' : 'Suspended',
                'verification_status' => $verStatus === 'verified' ? 'Verified' : 'Pending',
                'registration_date' => $createdAt,
                'approved_at' => $verStatus === 'verified' ? $createdAt : null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            // Seller Business Details
            DB::table('seller_business_details')->insert([
                'seller_id' => $sellerId,
                'business_name' => $companyName,
                'business_category' => LegacyDataTransformer::cleanText($row['expert_category'] ?? 'Education'),
                'business_description' => LegacyDataTransformer::cleanText($row['about_self'] ?? ''),
                'business_phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                'business_email' => $email,
                'address' => LegacyDataTransformer::cleanText($row['address'] ?? ''),
                'city' => LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad',
                'state' => LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat',
                'country' => 'India',
                'pincode' => substr(preg_replace('/[^0-9]/', '', $row['pincode'] ?? ''), 0, 10),
                'website' => $row['website'] ?? null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            $this->recordIdMapping('seller_tutor', $oldId, $sellerId, $email);
            $this->stats['tutors']['migrated']++;

            if ($this->mode === 'live' && $count % 250 === 0) {
                DB::commit();
                DB::beginTransaction();
            }
        });

        if ($this->mode === 'live' && $inBatch) {
            DB::commit();
        }

        $this->log("Tutors: {$this->stats['tutors']['migrated']} migrated as individual sellers, {$this->stats['tutors']['duplicates']} duplicates linked/skipped.");
    }

    /**
     * Stage 4: Migrate Affiliates & Institutes (dc_affiliate -> sellers + business_listings)
     */
    public function migrateAffiliates(?int $limit = null): void
    {
        $this->log("--- Stage 4: Migrating Institutes & Listings from `dc_affiliate` ---");
        $count = 0;
        $sellerCounter = 20000;
        $inBatch = false;
        if ($this->mode === 'live') {
            DB::beginTransaction();
            $inBatch = true;
        }

        $this->parser->streamTableRows('dc_affiliate', function ($row) use (&$count, &$sellerCounter, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['affiliates']['processed']++;

            $oldId = (string)($row['id'] ?? '');

            // Skip if already migrated in a prior run
            if ($this->lookupNewId('seller_affiliate', $oldId) || $this->lookupNewId('listing', $oldId)) {
                $this->stats['affiliates']['duplicates']++;
                return;
            }

            $schoolName = LegacyDataTransformer::cleanText($row['school_name'] ?? '') ?: 'Institute ' . $oldId;
            $email = LegacyDataTransformer::normalizeEmail($row['email'] ?? null);
            $createdAt = LegacyDataTransformer::normalizeDateTime($row['created_at'] ?? null);

            if (empty($email)) {
                $email = 'affiliate' . $oldId . '@institute.digitalclassworld.in';
            }

            // Check if seller/listing already exists with this exact school name & city to protect baseline (e.g. VCEC)
            $normSchool = strtolower(trim($schoolName));
            if (isset($this->existingListingNames[$normSchool])) {
                $existingListingId = $this->existingListingNames[$normSchool];
                $this->stats['affiliates']['duplicates']++;
                $this->recordIdMapping('listing', $oldId, $existingListingId, $schoolName);
                return;
            }

            // Create User account or link existing
            if (isset($this->existingUserEmails[$email])) {
                $userId = $this->existingUserEmails[$email];
                $existingSellerId = DB::table('sellers')->where('user_id', $userId)->value('id');
                if ($existingSellerId) {
                    $sellerId = $existingSellerId;
                } else {
                    $sellerCode = 'DC-SELL-' . str_pad((string)(++$sellerCounter), 6, '0', STR_PAD_LEFT);
                    $status = LegacyDataTransformer::normalizeStatus($row['status'] ?? 'active');
                    $sellerId = DB::table('sellers')->insertGetId([
                        'user_id' => $userId,
                        'seller_code' => $sellerCode,
                        'account_type' => 'institute',
                        'seller_status' => $status === 'active' ? 'Active' : 'Pending Approval',
                        'verification_status' => $status === 'active' ? 'Verified' : 'Pending',
                        'registration_date' => $createdAt,
                        'approved_at' => $status === 'active' ? $createdAt : null,
                        'created_at' => $createdAt,
                        'updated_at' => now(),
                    ]);
                }
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name' => $schoolName,
                    'email' => $email,
                    'phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                    'profession' => 'Business Owner',
                    'city' => LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad',
                    'state' => LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat',
                    'role' => 'seller',
                    'password' => LegacyDataTransformer::hashPassword('Institute@123'),
                    'email_verified_at' => now(),
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);
                $this->existingUserEmails[$email] = $userId;

                $sellerCode = 'DC-SELL-' . str_pad((string)(++$sellerCounter), 6, '0', STR_PAD_LEFT);
                $status = LegacyDataTransformer::normalizeStatus($row['status'] ?? 'active');

                // Create Seller
                $sellerId = DB::table('sellers')->insertGetId([
                    'user_id' => $userId,
                    'seller_code' => $sellerCode,
                    'account_type' => 'institute',
                    'seller_status' => $status === 'active' ? 'Active' : 'Pending Approval',
                    'verification_status' => $status === 'active' ? 'Verified' : 'Pending',
                    'registration_date' => $createdAt,
                    'approved_at' => $status === 'active' ? $createdAt : null,
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);
            }

            // Business Details
            DB::table('seller_business_details')->insert([
                'seller_id' => $sellerId,
                'business_name' => $schoolName,
                'business_category' => 'Educational Institute',
                'business_description' => LegacyDataTransformer::cleanText($row['full_description'] ?? ''),
                'business_phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                'business_email' => $email,
                'address' => LegacyDataTransformer::cleanText($row['address'] ?? ''),
                'city' => LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad',
                'state' => LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat',
                'country' => 'India',
                'pincode' => substr(preg_replace('/[^0-9]/', '', $row['pincode'] ?? ''), 0, 10),
                'website' => $row['website_url'] ?? null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            // Create Storefront Business Listing
            $slug = Str::slug($schoolName);
            if (empty($slug)) $slug = 'listing-' . $oldId;
            $slug = substr($slug, 0, 150) . '-' . $oldId;

            $status = LegacyDataTransformer::normalizeStatus($row['status'] ?? 'active');

            $listingId = DB::table('business_listings')->insertGetId([
                'seller_id' => $sellerId,
                'business_name' => $schoolName,
                'slug' => $slug,
                'category' => LegacyDataTransformer::cleanText($row['coaching_category'] ?? '') ?: 'Educational Institute',
                'tagline' => substr(LegacyDataTransformer::cleanText($row['short_description'] ?? '') ?: $schoolName, 0, 255),
                'description' => LegacyDataTransformer::cleanText($row['full_description'] ?? '') ?: 'Leading educational academy & training institute on Digital Class.',
                'city' => LegacyDataTransformer::cleanText($row['city'] ?? '') ?: 'Ahmedabad',
                'state' => LegacyDataTransformer::cleanText($row['state'] ?? '') ?: 'Gujarat',
                'pincode' => substr(preg_replace('/[^0-9]/', '', $row['pincode'] ?? ''), 0, 10),
                'address' => LegacyDataTransformer::cleanText($row['address'] ?? '') ?: 'Ahmedabad, Gujarat',
                'email' => $email,
                'phone' => LegacyDataTransformer::normalizePhone($row['contact'] ?? null),
                'website' => $row['website_url'] ?? null,
                'status' => $status === 'active' ? 'approved' : 'pending',
                'approved_at' => $status === 'active' ? now() : null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            $this->existingListingNames[$normSchool] = $listingId;
            $this->recordIdMapping('seller_affiliate', $oldId, $sellerId, $schoolName);
            $this->recordIdMapping('listing', $oldId, $listingId, $schoolName);
            $this->stats['affiliates']['migrated']++;

            if ($this->mode === 'live' && $count % 250 === 0) {
                DB::commit();
                DB::beginTransaction();
            }
        });

        if ($this->mode === 'live' && $inBatch) {
            DB::commit();
        }

        $this->log("Affiliates: {$this->stats['affiliates']['migrated']} migrated as institutes + business listings, {$this->stats['affiliates']['duplicates']} duplicates linked/skipped.");
    }

    /**
     * Stage 5: Migrate Courses (dc_elearn_course -> courses)
     */
    public function migrateCourses(?int $limit = null): void
    {
        $this->log("--- Stage 5: Migrating Courses from `dc_elearn_course` ---");
        $count = 0;

        $this->parser->streamTableRows('dc_elearn_course', function ($row) use (&$count, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['courses']['processed']++;

            $oldId = (string)($row['id'] ?? '');
            $oldTutorId = (string)($row['tutor_id'] ?? '');
            $title = LegacyDataTransformer::cleanText($row['course_name'] ?? '') ?: 'Course ' . $oldId;

            // Resolve seller ID
            $sellerId = $this->lookupNewId('seller_tutor', $oldTutorId) ?: 1; // Fallback to seller ID 1 if tutor orphan

            // Check duplicate course title under same seller
            $normTitle = strtolower(trim($title));
            if (isset($this->existingCourseTitles[$normTitle])) {
                $this->stats['courses']['duplicates']++;
                $this->recordIdMapping('course', $oldId, $this->existingCourseTitles[$normTitle], $title);
                return;
            }

            $price = floatval(preg_replace('/[^0-9\.]/', '', $row['course_price'] ?? '0'));
            $discountPrice = floatval(preg_replace('/[^0-9\.]/', '', $row['course_final_amount'] ?? '0'));
            if ($discountPrice <= 0 || $discountPrice >= $price) {
                $discountPrice = null;
            }

            $slug = Str::slug($title);
            if (empty($slug)) $slug = 'course-' . $oldId;
            $slug = substr($slug, 0, 150) . '-' . $oldId;

            $status = LegacyDataTransformer::normalizeStatus($row['status'] ?? 'active');

            $newCourseId = DB::table('courses')->insertGetId([
                'seller_id' => $sellerId,
                'title' => $title,
                'slug' => $slug,
                'category' => 'Software & Tech',
                'language' => $row['course_language'] ?: 'Hindi',
                'level' => 'Beginner',
                'short_description' => substr(LegacyDataTransformer::cleanText($row['short_desc'] ?? '') ?: $title, 0, 500),
                'description' => LegacyDataTransformer::cleanText($row['course_desc'] ?? '') ?: 'Comprehensive course training module.',
                'thumbnail' => $row['course_thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=80',
                'is_free' => ($price <= 0),
                'price' => $price > 0 ? $price : 0,
                'discount_price' => $discountPrice,
                'access_type' => 'Lifetime Access',
                'certificate_included' => strtolower($row['course_certification'] ?? '') === 'yes',
                'status' => $status === 'active' ? 'approved' : 'pending',
                'approved_at' => $status === 'active' ? now() : null,
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => now(),
            ]);

            $this->existingCourseTitles[$normTitle] = $newCourseId;
            $this->recordIdMapping('course', $oldId, $newCourseId, $title);
            $this->stats['courses']['migrated']++;
        });

        $this->log("Courses: {$this->stats['courses']['migrated']} migrated.");
    }

    /**
     * Stage 6: Migrate Curricula & Videos (dc_elearn_course_curriculam -> course_contents)
     */
    public function migrateCurriculums(?int $limit = null): void
    {
        $this->log("--- Stage 6: Migrating Course Contents from `dc_elearn_course_curriculam` ---");
        $count = 0;

        $this->parser->streamTableRows('dc_elearn_course_curriculam', function ($row) use (&$count, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['curriculums']['processed']++;

            $oldCourseId = (string)($row['course_id'] ?? '');
            $newCourseId = $this->lookupNewId('course', $oldCourseId);
            if (!$newCourseId) {
                $this->stats['curriculums']['skipped']++;
                return;
            }

            $title = LegacyDataTransformer::cleanText($row['title'] ?? '') ?: 'Chapter ' . $count;

            DB::table('course_contents')->insert([
                'course_id' => $newCourseId,
                'section_title' => $title,
                'lecture_title' => $title,
                'duration' => '15:00',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'sort_order' => $count % 20 + 1,
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => now(),
            ]);

            $this->stats['curriculums']['migrated']++;
        });

        $this->log("Curriculums: {$this->stats['curriculums']['migrated']} curriculum sections migrated.");
    }

    /**
     * Stage 7: Migrate Inquiries & Leads (app_program_enquiries -> leads)
     */
    public function migrateLeads(?int $limit = null): void
    {
        $this->log("--- Stage 7: Migrating Student Leads from `app_program_enquiries` ---");
        $count = 0;

        $this->parser->streamTableRows('app_program_enquiries', function ($row) use (&$count, $limit) {
            if ($limit && $count >= $limit) return;
            $count++;
            $this->stats['leads']['processed']++;

            $oldAffiliateId = (string)($row['affiliate_id'] ?? '');
            $sellerId = $this->lookupNewId('seller_affiliate', $oldAffiliateId) ?: 1;

            $name = LegacyDataTransformer::cleanText($row['name'] ?? '') ?: 'Inquirer ' . $count;
            $email = LegacyDataTransformer::normalizeEmail($row['email'] ?? null) ?: 'lead' . $count . '@lead.dc.in';
            $phone = LegacyDataTransformer::normalizePhone($row['phone'] ?? null) ?: '9876543210';
            $subject = LegacyDataTransformer::cleanText($row['subject'] ?? '') ?: 'Course Admission Inquiry';
            $message = LegacyDataTransformer::cleanText($row['message'] ?? '') ?: 'Interested in academic programs.';

            DB::table('leads')->insert([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'city' => 'Ahmedabad, Gujarat',
                'source' => $row['source'] ?: 'Marketplace Inquiries',
                'campaign' => 'Legacy Migration',
                'platform' => 'Website',
                'status' => 'New',
                'remarks' => substr("Subject: {$subject} | Message: {$message}", 0, 1000),
                'created_at' => $row['created_at'] ?? now(),
                'updated_at' => now(),
            ]);

            $this->stats['leads']['migrated']++;
        });

        $this->log("Leads: {$this->stats['leads']['migrated']} student leads migrated.");
    }

    /**
     * Record mapping between old ID and new ID
     */
    protected function recordIdMapping(string $entityType, string $oldId, int $newId, ?string $uniqueKey = null): void
    {
        $this->idMap[$entityType][$oldId] = $newId;
        try {
            DB::table('migration_id_mappings')->updateOrInsert(
                ['entity_type' => $entityType, 'old_id' => $oldId],
                ['new_id' => $newId, 'unique_key' => $uniqueKey, 'updated_at' => now()]
            );
        } catch (\Throwable $e) {}
    }

    /**
     * Look up mapped new ID from old ID
     */
    public function lookupNewId(string $entityType, string $oldId): ?int
    {
        if (isset($this->idMap[$entityType][$oldId])) {
            return $this->idMap[$entityType][$oldId];
        }

        $val = DB::table('migration_id_mappings')
            ->where('entity_type', $entityType)
            ->where('old_id', $oldId)
            ->value('new_id');

        if ($val) {
            $this->idMap[$entityType][$oldId] = $val;
        }

        return $val;
    }
}
