<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'order_number',
        'customer_name',
        'customer_city',
        'customer_email',
        'customer_phone',
        'customer_avatar',
        'order_type',
        'item_title',
        'item_subtext',
        'item_thumbnail',
        'amount',
        'subtotal',
        'discount',
        'status',
        'placed_at',
        'timeline',
    ];

    protected $casts = [
        'amount'    => 'decimal:2',
        'subtotal'  => 'decimal:2',
        'discount'  => 'decimal:2',
        'placed_at' => 'datetime',
        'timeline'  => 'array',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}

