<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'avatar',
        'city',
        'source',
        'campaign',
        'platform',
        'status',
        'assigned_to',
        'next_follow_up',
        'interested_in',
        'budget',
        'remarks',
        'activities',
        'notes',
    ];

    protected $casts = [
        'activities'     => 'array',
        'notes'          => 'array',
        'next_follow_up' => 'date',
    ];
}
