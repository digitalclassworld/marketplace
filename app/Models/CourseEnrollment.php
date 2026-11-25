<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $table = 'course_enrollments';

    protected $fillable = [
        'user_id',
        'course_id',
        'course_type',
        'order_id',
        'enrolled_at',
        'completed_at',
        'progress_percent',
        'last_watched_lesson_id',
        'status',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percent' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function elearnCourse(): BelongsTo
    {
        return $this->belongsTo(ElearnCourse::class, 'course_id');
    }

    public function catalogCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get polymorphic course instance.
     */
    public function getCourseAttribute()
    {
        if ($this->course_type === 'catalog') {
            return $this->catalogCourse ?: Course::find($this->course_id);
        }
        return $this->elearnCourse ?: ElearnCourse::find($this->course_id);
    }
}
