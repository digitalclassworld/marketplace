<?php

namespace App\Services;

use App\Models\Seller;
use Illuminate\Support\Facades\Log;

class SellerIdService
{
    public const PREFIX = 'DC-SELL-';
    public const PAD_LENGTH = 6;

    /**
     * Format a seller ID from a numeric database ID.
     * Example: id 1 -> DC-SELL-000001, id 125 -> DC-SELL-000125
     */
    public static function format(int $id): string
    {
        return self::PREFIX . str_pad((string)$id, self::PAD_LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a temporary unique placeholder code to satisfy non-null unique constraint
     * before assigning the final database-ID based seller_code.
     */
    public static function generateTempCode(): string
    {
        return 'TMP-' . bin2hex(random_bytes(8)); // 20 characters total
    }

    /**
     * Assign permanent formatted seller code using seller primary key id.
     */
    public function assignSellerCode(Seller $seller): Seller
    {
        $code = self::format($seller->id);
        $seller->seller_code = $code;
        $seller->save();

        Log::info("Seller ID {$code} generated for Seller #{$seller->id}");
        return $seller;
    }
}
