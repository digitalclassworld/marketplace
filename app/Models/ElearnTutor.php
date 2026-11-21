<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ElearnTutor extends Model
{
    use HasFactory;

    protected $table = 'dc_elearn_tutor';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Tutor SEO Slug
     */
    public function getSlugAttribute(): string
    {
        $base = !empty($this->name) ? $this->name : ($this->company_name ?: 'tutor');
        return Str::slug($base);
    }

    /**
     * Legacy & Canonical Tutor Profile URL: /e-learning/tutor/{slug}/{id}
     */
    public function getUrlAttribute(): string
    {
        return url('/e-learning/tutor/' . $this->slug . '/' . $this->id);
    }

    /**
     * Get safe profile image
     */
    public function getProfileUrlAttribute(): string
    {
        $img = trim($this->profile ?? '');
        if (!empty($img) && !str_contains($img, 'ic_profile.PNG')) {
            return preg_replace('/^http:\/\//i', 'https://', $img);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?: 'Tutor') . '&background=008060&color=fff&size=250';
    }

    /**
     * Get safe cover image
     */
    public function getCoverUrlAttribute(): string
    {
        $img = trim($this->cover_image ?? '');
        if (!empty($img)) {
            return preg_replace('/^http:\/\//i', 'https://', $img);
        }
        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&auto=format&fit=crop&q=80';
    }

    /**
     * Tutor courses
     */
    public function courses()
    {
        return $this->hasMany(ElearnCourse::class, 'tutor_id')
            ->where(function($q) {
                $q->where('status', 'active')
                  ->orWhereNull('status')
                  ->orWhere('status', '');
            })
            ->orderBy('id', 'desc');
    }

    /**
     * All courses including drafts/unapproved
     */
    public function allCourses()
    {
        return $this->hasMany(ElearnCourse::class, 'tutor_id')->orderBy('id', 'desc');
    }
}

