<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seller extends Model
{
    use HasFactory;

    // Account Types
    public const ACCOUNT_TYPE_INDIVIDUAL = 'Individual / Freelancer';
    public const ACCOUNT_TYPE_INSTITUTE  = 'Institute / Company';
    public const ACCOUNT_TYPE_AGENCY     = 'Agency';

    // Seller Statuses
    public const STATUS_PENDING_APPROVAL = 'Pending Approval';
    public const STATUS_ACTIVE           = 'Active';
    public const STATUS_REJECTED         = 'Rejected';
    public const STATUS_SUSPENDED        = 'Suspended';
    public const STATUS_INACTIVE         = 'Inactive';

    // Verification Statuses
    public const VERIFICATION_NOT_VERIFIED = 'Not Verified';
    public const VERIFICATION_PENDING      = 'Pending Verification';
    public const VERIFICATION_VERIFIED     = 'Verified';
    public const VERIFICATION_FAILED       = 'Verification Failed';

    protected $fillable = [
        'user_id',
        'seller_code',
        'account_type',
        'seller_status',
        'verification_status',
        'registration_date',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'rejected_at',
        'rejected_by',
        'suspended_at',
        'suspended_by',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
            'approved_at'       => 'datetime',
            'rejected_at'       => 'datetime',
            'suspended_at'      => 'datetime',
        ];
    }

    /**
     * Get the user account for this seller.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStoreNameAttribute(): string
    {
        return $this->businessDetail?->business_name 
            ?? $this->user?->name 
            ?? "Seller #{$this->seller_code}";
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function suspendedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'suspended_by');
    }

    /**
     * Get the business details of this seller.
     */
    public function businessDetail(): HasOne
    {
        return $this->hasOne(SellerBusinessDetail::class, 'seller_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function businessListings(): HasMany
    {
        return $this->hasMany(BusinessListing::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Status Helper Methods
     */
    public function isPendingApproval(): bool
    {
        return in_array($this->seller_status, [self::STATUS_PENDING_APPROVAL, 'Pending', 'pending']);
    }

    public function isActive(): bool
    {
        return in_array($this->seller_status, [self::STATUS_ACTIVE, 'Active', 'active']);
    }

    public function isRejected(): bool
    {
        return in_array($this->seller_status, [self::STATUS_REJECTED, 'Rejected', 'rejected']);
    }

    public function isSuspended(): bool
    {
        return in_array($this->seller_status, [self::STATUS_SUSPENDED, 'Suspended', 'suspended']);
    }

    public function isInactive(): bool
    {
        return in_array($this->seller_status, [self::STATUS_INACTIVE, 'Inactive', 'inactive']);
    }

    public function isVerified(): bool
    {
        return $this->verification_status === self::VERIFICATION_VERIFIED;
    }

    public function canSell(): bool
    {
        return $this->isActive();
    }
}

