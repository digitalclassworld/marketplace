<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'business_name',
        'slug',
        'category',
        'listing_type',
        'sub_category',
        'established_year',
        'employees_count',
        'tagline',
        'description',
        'features',
        'phone',
        'whatsapp_number',
        'email',
        'website',
        'address',
        'area',
        'landmark',
        'city',
        'state',
        'pincode',
        'map_location',
        'latitude',
        'longitude',
        'logo',
        'cover_image',
        'video_url',
        'gallery',
        'plan_name',
        'plan_price',
        'add_ons',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'features'    => 'array',
        'gallery'     => 'array',
        'add_ons'     => 'array',
        'plan_price'  => 'decimal:2',
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

    public function getCategorySlugAttribute(): string
    {
        // On digitalclassworld.com, all business directory listings are under /business-listing/coaching/{slug}
        return 'coaching';
    }

    public function getCleanSlugAttribute(): string
    {
        $raw = $this->slug ?: \Illuminate\Support\Str::slug($this->business_name);
        // Strip legacy trailing database ID (e.g. "ayush-education-consultancy-427" -> "ayush-education-consultancy")
        $clean = preg_replace('/-\d+$/', '', $raw);
        return !empty($clean) ? $clean : $raw;
    }

    public function getAffiliateIdAttribute(): ?int
    {
        if (preg_match('/-(\d+)$/', $this->slug ?? '', $matches)) {
            return (int) $matches[1];
        }
        return null;
    }

    public function getLegacyCoursesAttribute()
    {
        $affiliateId = $this->affiliate_id;
        if (!$affiliateId) {
            return collect();
        }
        return InstituteCourse::where('affiliate_id', $affiliateId)
            ->where(function($q) {
                $q->where('status', 'active')
                  ->orWhereNull('status')
                  ->orWhere('status', '');
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getUrlAttribute(): string
    {
        return url('/business-listing/coaching/' . $this->clean_slug);
    }

    public function getRatingAttribute(): float
    {
        return isset($this->features['rating']) ? (float)$this->features['rating'] : 0.0;
    }

    public function getReviewsCountAttribute(): int
    {
        return isset($this->features['reviews_count']) ? (int)$this->features['reviews_count'] : 0;
    }

    public function isFeatured(): bool
    {
        $plan = strtolower($this->plan_name ?? '');
        $type = strtolower($this->listing_type ?? '');
        $badge = strtolower($this->features['badge'] ?? '');
        return str_contains($plan, 'featured') 
            || $type === 'featured' 
            || $badge === 'featured'
            || (float)($this->plan_price ?? 0) >= 2999;
    }

    public function isPremium(): bool
    {
        $plan = strtolower($this->plan_name ?? '');
        $type = strtolower($this->listing_type ?? '');
        $badge = strtolower($this->features['badge'] ?? '');
        return $this->isFeatured()
            || str_contains($plan, 'premium') 
            || $type === 'premium' 
            || $badge === 'premium'
            || (float)($this->plan_price ?? 0) >= 1499;
    }

    public function hasHighSupport(): bool
    {
        if (isset($this->features['high_support']) && $this->features['high_support']) {
            return true;
        }
        return $this->isPremium();
    }

    public function isSuggestedFirst(): bool
    {
        if (isset($this->features['suggestion_first']) && $this->features['suggestion_first']) {
            return true;
        }
        return $this->isPremium();
    }

    public function hasVerifiedBadge(): bool
    {
        if ($this->isPremium()) {
            return true;
        }
        $addOns = $this->add_ons;
        if (is_array($addOns)) {
            if (!empty($addOns['verified_badge']) || in_array('verified_badge', $addOns) || in_array('Verified Business Badge', $addOns)) {
                return true;
            }
        }
        return strtolower($this->listing_type ?? '') === 'verified';
    }

    public function getPriorityRankAttribute(): int
    {
        if ($this->isFeatured()) {
            return 1;
        }
        if ($this->isPremium()) {
            return 2;
        }
        return 3;
    }

    public function getBadgeAttribute(): ?string
    {
        if (!empty($this->features['badge'])) {
            return $this->features['badge'];
        }
        if ($this->isFeatured()) {
            return 'Featured';
        }
        if ($this->isPremium()) {
            return 'Premium';
        }
        if ($this->hasVerifiedBadge()) {
            return 'Verified';
        }
        return null;
    }

    public function getTagsListAttribute(): array
    {
        if (isset($this->features['tags']) && is_array($this->features['tags'])) {
            return $this->features['tags'];
        }
        if (!empty($this->sub_category)) {
            return array_map('trim', explode(',', $this->sub_category));
        }
        return ['Verified', 'Professional'];
    }

    public function getAreaTextAttribute(): string
    {
        $area = $this->area ?? ($this->features['area'] ?? null);
        if ($area && $this->city) {
            return $area . ', ' . $this->city;
        }
        if ($area) {
            return $area;
        }
        return $this->city ?: ($this->address ?: 'Ahmedabad');
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

    public static array $educationProfileImages = [
        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80', // Academic Students Collaborative Study
        'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=600&auto=format&fit=crop&q=80', // Chalkboard & Learning Academy
        'https://images.unsplash.com/photo-1562774053-701939374585?w=600&auto=format&fit=crop&q=80', // University College Campus
        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&auto=format&fit=crop&q=80', // Classroom & Modern Education
        'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80', // Academy Classroom
        'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80', // Teaching & Coaching Seminar
        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80', // Books & Learning Academy
        'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&auto=format&fit=crop&q=80', // Library & Institute
    ];

    public static array $educationLogos = [
        'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1562774053-701939374585?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=200&auto=format&fit=crop&q=80',
    ];

    public function getDisplayImageAttribute(): string
    {
        if (!empty($this->cover_image) && !str_contains($this->cover_image, 'camera_placeholder')) {
            $img = $this->cover_image;
            return (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) ? $img : asset($img);
        }

        if (!empty($this->attributes['logo']) && !str_contains($this->attributes['logo'], 'camera_placeholder')) {
            $img = $this->attributes['logo'];
            return (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) ? $img : asset($img);
        }

        // Known legacy logos
        $clean = $this->clean_slug;
        $legacyLogos = [
            'kalashraya'                     => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/6068/institute-logo1738392221.png',
            'legend-dance-academy'           => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5544/institute-logo1736487363.jpg',
            'g-k-dance-academy'              => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5540/institute-logo1736485988.jpg',
            'shree-aurbindo-miera-academy'   => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5551/institute-logo1736486898.jfif',
            'medhaavee-mandir-public-school' => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/school/school_icon/14134/school-logo1731148257.jpg',
        ];

        if (isset($legacyLogos[$clean])) {
            return $legacyLogos[$clean];
        }

        // Education-related default profile image if none uploaded
        $seed = abs(crc32($this->business_name ?: ($this->id ?: 'edu_business')));
        return self::$educationProfileImages[$seed % count(self::$educationProfileImages)];
    }

    public static array $cityCoordinates = [
        'ahmedabad'    => ['lat' => 23.0225, 'lng' => 72.5714],
        'surat'        => ['lat' => 21.1702, 'lng' => 72.8311],
        'vadodara'     => ['lat' => 22.3072, 'lng' => 73.1812],
        'baroda'       => ['lat' => 22.3072, 'lng' => 73.1812],
        'rajkot'       => ['lat' => 22.3039, 'lng' => 70.8022],
        'gandhinagar'  => ['lat' => 23.2156, 'lng' => 72.6369],
        'mumbai'       => ['lat' => 19.0760, 'lng' => 72.8777],
        'pune'         => ['lat' => 18.5204, 'lng' => 73.8567],
        'delhi'        => ['lat' => 28.6139, 'lng' => 77.2090],
        'delhi ncr'    => ['lat' => 28.6139, 'lng' => 77.2090],
        'bengaluru'    => ['lat' => 12.9716, 'lng' => 77.5946],
        'bangalore'    => ['lat' => 12.9716, 'lng' => 77.5946],
        'hyderabad'    => ['lat' => 17.3850, 'lng' => 78.4867],
        'chennai'      => ['lat' => 13.0827, 'lng' => 80.2707],
        'kolkata'      => ['lat' => 22.5726, 'lng' => 88.3639],
        'jaipur'       => ['lat' => 26.9124, 'lng' => 75.7873],
        'indore'       => ['lat' => 22.7196, 'lng' => 75.8577],
        'bhopal'       => ['lat' => 23.2599, 'lng' => 77.4126],
        'lucknow'      => ['lat' => 26.8467, 'lng' => 80.9462],
        'chandigarh'   => ['lat' => 30.7333, 'lng' => 76.7794],
        'patna'        => ['lat' => 25.5941, 'lng' => 85.1376],
        'muzaffarpur'  => ['lat' => 26.1209, 'lng' => 85.3647],
        'nagpur'       => ['lat' => 21.1458, 'lng' => 79.0882],
        'nashik'       => ['lat' => 19.9975, 'lng' => 73.7898],
        'bhavnagar'    => ['lat' => 21.7645, 'lng' => 72.1519],
        'jamnagar'     => ['lat' => 22.4707, 'lng' => 70.0577],
        'junagadh'     => ['lat' => 21.5222, 'lng' => 70.4579],
        'anand'        => ['lat' => 22.5645, 'lng' => 72.9289],
        'navsari'      => ['lat' => 20.9467, 'lng' => 72.9520],
        'vapi'         => ['lat' => 20.3712, 'lng' => 72.9106],
        'valsad'       => ['lat' => 20.5992, 'lng' => 72.9342],
        'mehsana'      => ['lat' => 23.5880, 'lng' => 72.3693],
    ];

    public function getEffectiveLatitudeAttribute(): ?float
    {
        if (!empty($this->latitude)) {
            return (float)$this->latitude;
        }
        if (!empty($this->map_location) && preg_match('/(-?\d+\.\d+),\s*(-?\d+\.\d+)/', $this->map_location, $m)) {
            return (float)$m[1];
        }
        $cityKey = strtolower(trim($this->city ?? ''));
        return self::$cityCoordinates[$cityKey]['lat'] ?? null;
    }

    public function getEffectiveLongitudeAttribute(): ?float
    {
        if (!empty($this->longitude)) {
            return (float)$this->longitude;
        }
        if (!empty($this->map_location) && preg_match('/(-?\d+\.\d+),\s*(-?\d+\.\d+)/', $this->map_location, $m)) {
            return (float)$m[2];
        }
        $cityKey = strtolower(trim($this->city ?? ''));
        return self::$cityCoordinates[$cityKey]['lng'] ?? null;
    }

    public function calculateDistanceKm(?float $userLat, ?float $userLng): ?float
    {
        if ($userLat === null || $userLng === null) {
            return null;
        }
        $lat = $this->effective_latitude;
        $lng = $this->effective_longitude;
        if ($lat === null || $lng === null) {
            return null;
        }

        $earthRadius = 6371; // km
        $dLat = deg2rad($lat - $userLat);
        $dLng = deg2rad($lng - $userLng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($userLat)) * cos(deg2rad($lat)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 1);
    }

    public function getLogoAttribute(?string $value): string
    {
        if (!empty($value) && !str_contains($value, 'camera_placeholder')) {
            if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                return $value;
            }
            return asset($value);
        }

        // Known legacy logos
        $clean = $this->clean_slug;
        $legacyLogos = [
            'kalashraya'                     => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/6068/institute-logo1738392221.png',
            'legend-dance-academy'           => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5544/institute-logo1736487363.jpg',
            'g-k-dance-academy'              => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5540/institute-logo1736485988.jpg',
            'shree-aurbindo-miera-academy'   => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/institute/institute_icon/5551/institute-logo1736486898.jfif',
            'medhaavee-mandir-public-school' => 'https://digitalclassworld.com/business-listing/storage/app/app_resources/seller/school/school_icon/14134/school-logo1731148257.jpg',
        ];

        if (isset($legacyLogos[$clean])) {
            return $legacyLogos[$clean];
        }

        // Education-related default institute logo if none uploaded
        $seed = abs(crc32($this->business_name ?: ($this->id ?: 'edu_logo')));
        return self::$educationLogos[$seed % count(self::$educationLogos)];
    }
}

