<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no',
        'student_id',
        'student_name',
        'course_title',
        'course_id',
        'seller_id',
        'user_id',
        'order_id',
        'duration',
        'start_date',
        'completion_date',
        'instructor_name',
        'instructor_title',
        'instructor_signature',
        'signatory_name',
        'signatory_title',
        'institute_name',
        'signatory_signature',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate a unique certificate number like DC2026-00128
     */
    public static function generateCertificateNo(): string
    {
        $year = date('Y');
        $count = static::count() + 1;
        return sprintf('DC%s-%05d', $year, $count);
    }
}

