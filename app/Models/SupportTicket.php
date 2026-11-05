<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_avatar',
        'customer_city',
        'user_type',
        'interested_in',
        'previous_orders',
        'total_spent',
        'category',
        'sub_category',
        'source',
        'priority',
        'status',
        'assigned_to',
        'last_message',
        'last_message_at',
        'last_reply_at',
        'is_unread',
        'attachment_name',
        'attachment_size',
        'attachment_url',
        'activities',
        'internal_notes',
    ];

    protected $casts = [
        'activities'       => 'array',
        'last_message_at'  => 'datetime',
        'last_reply_at'    => 'datetime',
        'is_unread'        => 'boolean',
        'total_spent'      => 'decimal:2',
        'previous_orders'  => 'integer',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(SupportTicketMessage::class, 'ticket_id')->orderBy('created_at', 'asc');
    }
}
