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
     * Category ID to human-readable category name mapping
     */
    public static array $categoryMap = [
        2  => 'IT & Software Development',
        15 => 'Accounts & Finance',
        37 => 'Designing & Creative',
        49 => 'Digital Marketing',
        3  => 'School & Academics',
        16 => 'Business Management',
        42 => 'Accounting & Commerce',
        17 => 'Career & Leadership',
        44 => 'Competitive Exams & Law',
        47 => 'Business Administration',
        45 => 'Test Preparation & Languages',
        48 => 'Cyber & Information Security',
        12 => 'Music & Arts',
        4  => 'Spoken English',
        39 => 'Database & Cloud Administration',
    ];

    /**
     * Relationship to Tutor
     */
    public function tutor()
    {
        return $this->belongsTo(ElearnTutor::class, 'tutor_id');
    }

    /**
     * Category name accessor
     */
    public function getCategoryAttribute(): string
    {
        if (!empty($this->category_id) && isset(self::$categoryMap[$this->category_id])) {
            return self::$categoryMap[$this->category_id];
        }
        if (!empty($this->course_selling_for)) {
            return $this->course_selling_for;
        }
        return 'General Education';
    }

    /**
     * Instructor / Tutor Name
     */
    public function getInstructorNameAttribute(): string
    {
        if ($this->tutor) {
            return !empty($this->tutor->name) ? $this->tutor->name : ($this->tutor->company_name ?? 'Digital Class Instructor');
        }
        return 'Digital Class Instructor';
    }

    /**
     * Instructor / Tutor Avatar
     */
    public function getInstructorAvatarAttribute(): string
    {
        if ($this->tutor && !empty($this->tutor->profile_url)) {
            return $this->tutor->profile_url;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->instructor_name);
    }

    /**
     * Badge (Featured / Bestseller)
     */
    public function getBadgeAttribute(): string
    {
        return $this->is_trending ? 'Bestseller' : 'Featured';
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
     * Selling price accessor
     */
    public function getSellingPriceAttribute(): float
    {
        return $this->price;
    }

    /**
     * Discounted selling price (if discounted, or 0)
     */
    public function getDiscountPriceAttribute(): float
    {
        $orig = $this->original_price;
        $sell = $this->price;
        if ($orig > $sell && $sell > 0) {
            return $sell;
        }
        return 0.0;
    }

    /**
     * Discount percentage accessor
     */
    public function getDiscountPercentageAttribute(): string
    {
        return $this->discount_text;
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
     * Curated Education-Related Course Thumbnails
     */
    public static array $educationCourseThumbnails = [
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80', // Online digital study
        'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=600&auto=format&fit=crop&q=80', // Study desk with notes
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&auto=format&fit=crop&q=80', // Web Development & Coding
        'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&auto=format&fit=crop&q=80', // Student studying with laptop
        'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&auto=format&fit=crop&q=80', // Classroom seminar & workshop
        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80', // Group academic study
        'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80', // Teacher teaching class
        'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80', // Modern classroom
    ];

    /**
     * Skill level (e.g. "All level")
     */
    public function getLevelAttribute(): string
    {
        $lvl = trim($this->skill_level ?? '');
        return !empty($lvl) ? $lvl : 'All level';
    }

    /**
     * Safe thumbnail URL (guarantees a rich educational image, never a placeholder icon)
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumb = trim($this->course_thumbnail ?? '');
        if (!empty($thumb) && !str_contains($thumb, 'camera_placeholder')) {
            return preg_replace('/^http:\/\//i', 'https://', $thumb);
        }
        $self = trim($this->course_self_thumbnail ?? $this->self_thumbnail ?? '');
        if (!empty($self) && !str_contains($self, 'camera_placeholder')) {
            return preg_replace('/^http:\/\//i', 'https://', $self);
        }
        $seed = abs(crc32($this->course_name ?: ($this->id ?: 'edu_elearn')));
        return self::$educationCourseThumbnails[$seed % count(self::$educationCourseThumbnails)];
    }

    public function getThumbnailAttribute(): string
    {
        return $this->getThumbnailUrlAttribute();
    }

    /**
     * Get structured video chapters with nested lessons for learning player.
     */
    public function getVideoChapters(): \Illuminate\Support\Collection
    {
        $chapters = \Illuminate\Support\Facades\DB::table('dc_elearn_course_video_chapter')
            ->where('course_id', $this->id)
            ->where('status', 'active')
            ->orderBy('chapter_no', 'asc')
            ->get();

        if ($chapters->isEmpty()) {
            return collect();
        }

        $chapterIds = $chapters->pluck('id')->toArray();
        $videos = \Illuminate\Support\Facades\DB::table('dc_elearn_course_video')
            ->whereIn('chapter_id', $chapterIds)
            ->where('status', 'active')
            ->orderBy('lesson_no', 'asc')
            ->get()
            ->groupBy('chapter_id');

        return $chapters->map(function ($chapter) use ($videos) {
            $chapter->lessons = $videos->get($chapter->id, collect());
            return $chapter;
        });
    }

    /**
     * Get all lessons in a flat list.
     */
    public function getAllLessons(): \Illuminate\Support\Collection
    {
        $chapters = $this->getVideoChapters();
        $allLessons = collect();
        foreach ($chapters as $ch) {
            foreach ($ch->lessons as $lesson) {
                $lesson->chapter_name = $ch->chapter_name;
                $lesson->chapter_no = $ch->chapter_no;
                $allLessons->push($lesson);
            }
        }
        return $allLessons;
    }
}

