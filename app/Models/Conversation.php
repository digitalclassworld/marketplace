<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_avatar',
        'customer_city',
        'customer_online_status',
        'subject_title',
        'subject_type',
        'subject_thumbnail',
        'category',
        'status',
        'total_messages',
        'unread_count',
        'last_message',
        'last_message_at',
        'active_since',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'active_since' => 'date',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }
}

