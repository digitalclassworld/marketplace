<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerBusinessDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'business_name',
        'business_email',
        'business_phone',
        'business_category',
        'business_description',
        'website',
        'address',
        'area',
        'landmark',
        'city',
        'state',
        'country',
        'pincode',
        'logo',
    ];

    /**
     * Get the seller that owns this business detail.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->landmark,
            $this->area,
            $this->city,
            $this->state ? ($this->pincode ? $this->state . ' - ' . $this->pincode : $this->state) : $this->pincode,
        ]);
        return count($parts) > 0 ? implode(', ', $parts) : ($this->address ?: 'Ahmedabad, Gujarat');
    }
}

