<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLectureNote extends Model
{
    use HasFactory;

    protected $table = 'student_lecture_notes';

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'note',
        'timestamp_seconds',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
