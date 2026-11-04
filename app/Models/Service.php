<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'short_description',
        'description',
        'tags',
        'delivery_days',
        'package_name',
        'price',
        'package_features',
        'buyer_requirements',
        'thumbnail',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'delivery_days' => 'integer',
        'price' => 'decimal:2',
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

