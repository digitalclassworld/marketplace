<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'section_title',
        'lecture_title',
        'duration',
        'video_url',
        'sort_order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}

