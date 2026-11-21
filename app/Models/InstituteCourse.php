<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteCourse extends Model
{
    use HasFactory;

    protected $table = 'dc_affiliate_institute_course';

    public $timestamps = false;

    protected $fillable = [
        'affiliate_id',
        'course_thumbnail',
        'course_name',
        'course_desc',
        'course_by',
        'course_highlight',
        'course_language',
        'sessions',
        'duration',
        'course_price',
        'course_discount_price',
        'course_final_amount',
        'name_of_instructor',
        'about',
        'experience',
        'email',
        'education',
        'upi_id',
        'status',
        'created_at',
    ];

    /**
     * Get computed selling price
     */
    public function getPriceAttribute(): float
    {
        $final = (float) ($this->course_final_amount ?? 0);
        if ($final > 0) {
            return $final;
        }

        $disc = (float) ($this->course_discount_price ?? 0);
        if ($disc > 0) {
            return $disc;
        }

        return (float) ($this->course_price ?? 0);
    }

    /**
     * Get original / MRP price
     */
    public function getOriginalPriceAttribute(): float
    {
        $orig = (float) ($this->course_price ?? 0);
        $selling = $this->price;

        if ($orig > $selling && $selling > 0) {
            return $orig;
        }

        if ($selling > 0) {
            return round($selling * 1.3);
        }

        return 0.0;
    }

    /**
     * Get percentage discount
     */
    public function getDiscountPercentageAttribute(): string
    {
        $orig = $this->original_price;
        $selling = $this->price;

        if ($orig > $selling && $orig > 0) {
            $pct = round((($orig - $selling) / $orig) * 100);
            return $pct > 0 ? "{$pct}% OFF" : '';
        }

        return '';
    }

    /**
     * Get safe thumbnail image URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumb = trim($this->course_thumbnail ?? '');
        if (!empty($thumb)) {
            if (str_starts_with($thumb, 'http://') || str_starts_with($thumb, 'https://')) {
                return $thumb;
            }
            return 'https://digitalclassworld.com/business-listing/storage/app/' . ltrim($thumb, '/');
        }

        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80';
    }

    /**
     * Clean course slug matching legacy URL structure
     */
    public function getSlugAttribute(): string
    {
        if (!empty($this->course_by)) {
            return \Illuminate\Support\Str::slug($this->course_by);
        }

        if ($this->affiliate_id) {
            try {
                $affSlug = \Illuminate\Support\Facades\DB::table('dc_affiliate')
                    ->where('id', $this->affiliate_id)
                    ->value('url_slug');
                if (!empty($affSlug)) {
                    return \Illuminate\Support\Str::slug($affSlug);
                }
                $schoolName = \Illuminate\Support\Facades\DB::table('dc_affiliate')
                    ->where('id', $this->affiliate_id)
                    ->value('school_name');
                if (!empty($schoolName)) {
                    return \Illuminate\Support\Str::slug($schoolName);
                }
            } catch (\Throwable $e) {}
        }

        return \Illuminate\Support\Str::slug($this->course_name ?: 'institute-course');
    }

    /**
     * Direct target URL: /business-listing/course/{id}/{slug}
     */
    public function getUrlAttribute(): string
    {
        return url('/business-listing/course/' . $this->id . '/' . $this->slug);
    }
}

