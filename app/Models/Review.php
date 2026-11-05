<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_city',
        'user_avatar',
        'rating',
        'review_text',
        'review_type',
        'item_id',
        'item_title',
        'item_thumbnail',
        'seller_id',
        'seller_name',
        'category',
        'order_id',
        'enrolled_on',
        'completed_on',
        'photos',
        'status',
        'helpful_upvotes',
        'helpful_downvotes',
        'admin_notes',
        'is_featured',
    ];

    protected $casts = [
        'rating'            => 'float',
        'photos'            => 'array',
        'is_featured'       => 'boolean',
        'helpful_upvotes'   => 'integer',
        'helpful_downvotes' => 'integer',
        'enrolled_on'       => 'date',
        'completed_on'      => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}

