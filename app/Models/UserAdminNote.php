<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdminNote extends Model
{
    use HasFactory;

    protected $table = 'user_admin_notes';

    protected $fillable = [
        'user_id',
        'admin_id',
        'admin_name',
        'note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
