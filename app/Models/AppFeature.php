<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFeature extends Model
{
    use HasFactory;

    protected $table = 'app_features';

    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'color',
        'is_enabled',
        'order_index',
        'platforms',
    ];

    protected $casts = [
        'is_enabled'  => 'boolean',
        'order_index' => 'integer',
        'platforms'   => 'array',
    ];
}
