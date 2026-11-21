<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ElearnCourse extends Model
{
    use HasFactory;

    protected $table = 'dc_elearn_course';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Relationship to Tutor
     */
    public function tutor()
    {
        return $this->belongsTo(ElearnTutor::class, 'tutor_id');
    }

    /**
     * Clean SEO Slug
     */
    public function getSlugAttribute(): string
    {
        return Str::slug($this->course_name ?: 'course');
    }

    /**
     * Target / Legacy Course URL: /e-learning/course/{id}/{slug}
     */
    public function getUrlAttribute(): string
    {
        return url('/e-learning/course/' . $this->id . '/' . $this->slug);
    }

    /**
     * Uniform Title accessor
     */
    public function getTitleAttribute(): string
    {
        return $this->course_name ?? '';
    }

    /**
     * Short display title
     */
    public function getShortTitleAttribute(): string
    {
        $name = trim($this->course_name ?? '');
        if (mb_strlen($name) > 23) {
            return mb_substr($name, 0, 21) . '..';
        }
        return $name;
    }

    /**
     * Uniform Selling Price accessor
     */
    public function getPriceAttribute(): float
    {
        if ($this->course_final_amount !== null && $this->course_final_amount !== '') {
            return (float) $this->course_final_amount;
        }
        return (float) ($this->course_price ?? 0);
    }

    /**
     * Original MRP Price accessor
     */
    public function getOriginalPriceAttribute(): float
    {
        return (float) ($this->course_price ?? 0);
    }

    /**
     * Discount badge string (e.g. "92% off" or "50% off" or "0% off")
     */
    public function getDiscountTextAttribute(): string
    {
        $disc = (float) ($this->course_discount ?? 0);
        if ($disc > 0) {
            return round($disc) . '% off';
        }
        $orig = $this->original_price;
        $price = $this->price;
        if ($orig > $price && $orig > 0) {
            $calc = round((($orig - $price) / $orig) * 100);
            return $calc . '% off';
        }
        return '0% off';
    }

    /**
     * Skill level (e.g. "All level")
     */
    public function getLevelAttribute(): string
    {
        $lvl = trim($this->skill_level ?? '');
        return !empty($lvl) ? $lvl : 'All level';
    }

    /**
     * Safe thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumb = trim($this->course_thumbnail ?? '');
        if (!empty($thumb)) {
            return preg_replace('/^http:\/\//i', 'https://', $thumb);
        }
        $self = trim($this->course_self_thumbnail ?? $this->self_thumbnail ?? '');
        if (!empty($self)) {
            return preg_replace('/^http:\/\//i', 'https://', $self);
        }
        return 'https://digitalclassworld.com/business-listing/public/camera_placeholder.png';
    }
}

