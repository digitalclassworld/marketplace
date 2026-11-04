<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'product_type',
        'description',
        'sku',
        'mrp',
        'price',
        'stock_quantity',
        'weight_grams',
        'shipping_details',
        'thumbnail',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'mrp' => 'decimal:2',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'weight_grams' => 'integer',
        'approved_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}

