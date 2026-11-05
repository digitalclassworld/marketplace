<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformNotification extends Model
{
    use HasFactory;

    protected $table = 'platform_notifications';

    protected $fillable = [
        'title',
        'message',
        'channel',
        'type',
        'audience',
        'audience_count',
        'platforms',
        'status',
        'scheduled_at',
        'sent_at',
        'image_url',
        'target_link',
        'recipients_count',
        'opened_count',
        'clicked_count',
        'created_by',
    ];

    protected $casts = [
        'platforms'        => 'array',
        'scheduled_at'     => 'datetime',
        'sent_at'          => 'datetime',
        'audience_count'   => 'integer',
        'recipients_count' => 'integer',
        'opened_count'     => 'integer',
        'clicked_count'    => 'integer',
    ];

    /**
     * Helper to get type badge color classes
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match (strtolower($this->type)) {
            'promotion'  => 'badge-type-promotion',
            'course'     => 'badge-type-course',
            'system'     => 'badge-type-system',
            'update'     => 'badge-type-update',
            'reminder'   => 'badge-type-reminder',
            'welcome'    => 'badge-type-welcome',
            'engagement' => 'badge-type-engagement',
            'product'    => 'badge-type-product',
            'event'      => 'badge-type-event',
            default      => 'badge-type-default',
        };
    }

    /**
     * Helper to get status badge classes
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match (strtolower($this->status)) {
            'sent'      => 'badge-status-sent',
            'scheduled' => 'badge-status-scheduled',
            'draft'     => 'badge-status-draft',
            'failed'    => 'badge-status-failed',
            default     => 'badge-secondary',
        };
    }

    /**
     * Helper to get default or custom image url
     */
    public function getDisplayImageAttribute(): string
    {
        if (!empty($this->image_url)) {
            return $this->image_url;
        }

        return match (strtolower($this->type)) {
            'promotion'  => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=120&q=80',
            'course'     => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=120&q=80',
            'system'     => 'https://images.unsplash.com/photo-1581291518655-9523c932deb3?auto=format&fit=crop&w=120&q=80',
            'update'     => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=120&q=80',
            'reminder'   => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=120&q=80',
            'welcome'    => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=120&q=80',
            'engagement' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=120&q=80',
            'product'    => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=120&q=80',
            'event'      => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=120&q=80',
            default      => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=120&q=80',
        };
    }
}

