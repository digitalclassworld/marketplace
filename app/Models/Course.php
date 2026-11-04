<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'slug',
        'category',
        'language',
        'level',
        'short_description',
        'description',
        'thumbnail',
        'is_free',
        'price',
        'discount_price',
        'access_type',
        'certificate_included',
        'qa_enabled',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'certificate_included' => 'boolean',
        'qa_enabled' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(CourseContent::class)->orderBy('sort_order', 'asc');
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

