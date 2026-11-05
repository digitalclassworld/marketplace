<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $table = 'app_settings';

    protected $fillable = [
        'platform',
        'app_name',
        'package_name',
        'bundle_id',
        'description',
        'short_description',
        'current_version',
        'status',
        'icon_url',
        'splash_url',
        'login_screen_url',
        'home_screen_url',
        'total_downloads',
        'active_users',
        'rating',
        'crash_rate',
        'last_released_at',
    ];

    protected $casts = [
        'last_released_at' => 'datetime',
        'total_downloads'  => 'integer',
        'active_users'     => 'integer',
        'rating'           => 'float',
        'crash_rate'       => 'float',
    ];
}
