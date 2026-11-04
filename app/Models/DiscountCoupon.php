<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'coupon_code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'applicable_to',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'status',
    ];

    protected $casts = [
        'discount_value'   => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'valid_from'       => 'date',
        'valid_until'      => 'date',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}

