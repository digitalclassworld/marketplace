<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'phone',
        'profession',
        'city',
        'state',
        'interests',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            if (file_exists(public_path($this->avatar))) {
                return asset($this->avatar);
            }
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0066ff&color=fff&size=128&bold=true';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the seller profile associated with the user.
     */
    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class, 'user_id');
    }

    public function adminNotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserAdminNote::class, 'user_id');
    }

    /**
     * Role checking helpers
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->role === 'superadmin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Get a clean, displayable label for customer profession/type.
     */
    public function getProfessionLabelAttribute(): string
    {
        if (empty($this->profession)) {
            return 'Customer';
        }

        $raw = trim($this->profession);

        if (str_starts_with($raw, 'Student')) {
            return 'Student';
        }
        if (str_starts_with($raw, 'Parent')) {
            return 'Parent';
        }
        if (str_starts_with($raw, 'Teacher') || str_starts_with($raw, 'Educator')) {
            return 'Teacher';
        }
        if (str_starts_with($raw, 'Business')) {
            return 'Business Owner';
        }
        if (str_starts_with($raw, 'Working')) {
            return 'Working Professional';
        }
        if (str_starts_with($raw, 'Job')) {
            return 'Job Seeker';
        }
        if (str_starts_with($raw, 'Retailer')) {
            return 'Retailer';
        }
        if (str_starts_with($raw, 'Freelancer')) {
            return 'Freelancer';
        }
        if (str_starts_with($raw, 'Institute')) {
            return 'Institute';
        }

        if (str_contains($raw, '/')) {
            $parts = explode('/', $raw);
            return trim($parts[0]);
        }

        return $raw;
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseEnrollment::class, 'user_id');
    }

    public function progress(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentCourseProgress::class, 'user_id');
    }

    public function lectureNotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentLectureNote::class, 'user_id');
    }

    public function isEnrolledIn(int $courseId, string $type = 'elearn'): bool
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->where('course_type', $type)
            ->exists();
    }
}
