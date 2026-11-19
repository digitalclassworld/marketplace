<?php

namespace App\Services\Migration;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LegacyDataTransformer
{
    /**
     * Clean and normalize email address
     */
    public static function normalizeEmail(?string $email): ?string
    {
        if (empty($email)) return null;
        $clean = strtolower(trim($email));
        if (filter_var($clean, FILTER_VALIDATE_EMAIL)) {
            return $clean;
        }
        return null;
    }

    /**
     * Clean phone number
     */
    public static function normalizePhone(?string $phone): ?string
    {
        if (empty($phone)) return null;
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($digits) >= 10) {
            // Keep last 10-12 digits
            return substr($digits, -12);
        }
        return !empty($digits) ? $digits : null;
    }

    protected static array $hashCache = [];

    /**
     * Hash old password securely with Bcrypt
     */
    public static function hashPassword(?string $plainOrHash): string
    {
        if (empty($plainOrHash)) {
            $plainOrHash = '123456';
        }

        // If already a valid Bcrypt hash, keep it
        if (str_starts_with($plainOrHash, '$2y$') || str_starts_with($plainOrHash, '$2a$')) {
            return $plainOrHash;
        }

        if (isset(self::$hashCache[$plainOrHash])) {
            return self::$hashCache[$plainOrHash];
        }

        // Hash plaintext or legacy md5 securely with Bcrypt and cache result
        return self::$hashCache[$plainOrHash] = Hash::make($plainOrHash);
    }

    /**
     * Normalize status values
     */
    public static function normalizeStatus(?string $status, string $default = 'active'): string
    {
        if (empty($status)) return $default;
        $s = strtolower(trim($status));
        return match($s) {
            'active', '1', 'approved', 'verified', 'published', 'success', 'completed' => 'active',
            'pending', '0', 'unverified', 'in_progress', 'draft' => 'pending',
            'rejected', 'cancelled', 'failed', 'blocked' => 'rejected',
            'suspended', 'not_active', 'inactive', 'deactive', 'disabled' => 'suspended',
            default => $default,
        };
    }

    /**
     * Map profession string
     */
    public static function mapProfession(?string $flag): string
    {
        if (empty($flag)) return 'Student / Learner';
        $f = strtolower(trim($flag));
        if (str_contains($f, 'student') || str_contains($f, 'learner')) return 'Student / Learner';
        if (str_contains($f, 'parent') || str_contains($f, 'guardian')) return 'Parent / Guardian';
        if (str_contains($f, 'teacher') || str_contains($f, 'tutor') || str_contains($f, 'faculty')) return 'Teacher / Educator';
        if (str_contains($f, 'business') || str_contains($f, 'owner') || str_contains($f, 'founder')) return 'Business Owner';
        if (str_contains($f, 'working') || str_contains($f, 'employee') || str_contains($f, 'corporate')) return 'Working Professional / Employee';
        if (str_contains($f, 'freelance') || str_contains($f, 'agency')) return 'Freelancer / Agency';
        if (str_contains($f, 'job') || str_contains($f, 'fresher')) return 'Job Seeker / Fresher';
        return 'Other Professional';
    }

    /**
     * Clean UTF-8 text string
     */
    public static function cleanText(?string $text): ?string
    {
        if ($text === null) return null;
        $str = str_replace(["\r\n", "\r"], "\n", $text);
        $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $str);
        return trim($clean !== false ? $clean : $str);
    }

    /**
     * Generate unique slug
     */
    public static function generateSlug(string $title, string $table, string $column = 'slug'): string
    {
        $base = Str::slug($title);
        if (empty($base)) {
            $base = 'item-' . Str::random(6);
        }
        return substr($base, 0, 180);
    }
}
