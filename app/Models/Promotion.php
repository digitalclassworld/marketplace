<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    // Promotion Plans and Charges requested by the user:
    // 1000, 1500, 2000, 2500
    public const TYPE_FEATURED_LISTING = 'Featured Listing';   // ₹1,000
    public const TYPE_BANNER_PROMOTION = 'Banner Promotion';   // ₹1,500
    public const TYPE_DISCOUNT_OFFER   = 'Discount Offer';     // ₹1,000
    public const TYPE_SOCIAL_MEDIA_KIT = 'Social Media Kit';   // ₹2,000
    public const TYPE_EMAIL_CAMPAIGN   = 'Email Campaign';     // ₹2,500

    public static array $pricing = [
        self::TYPE_FEATURED_LISTING => 1000,
        self::TYPE_BANNER_PROMOTION => 1500,
        self::TYPE_DISCOUNT_OFFER   => 1000,
        self::TYPE_SOCIAL_MEDIA_KIT => 2000,
        self::TYPE_EMAIL_CAMPAIGN   => 2500,
    ];

    protected $fillable = [
        'seller_id',
        'promotion_code',
        'listing_type',
        'listing_id',
        'listing_title',
        'listing_thumbnail',
        'original_price',
        'offer_price',
        'discount_percentage',
        'promotion_type',
        'charge_amount',
        'duration_days',
        'start_date',
        'end_date',
        'status',
        'views_count',
        'clicks_count',
        'sales_count',
        'revenue_generated',
        'banner_template',
        'target_audience',
        'payment_status',
    ];

    protected $casts = [
        'original_price'    => 'decimal:2',
        'offer_price'       => 'decimal:2',
        'charge_amount'     => 'decimal:2',
        'revenue_generated' => 'decimal:2',
        'start_date'        => 'date',
        'end_date'          => 'date',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}

