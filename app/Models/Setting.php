<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'ai_key',
        'ai_provider',
        'gemini_key',
        'ai_features',
        'enabled',
        'enable_description',
        'enable_reply',
        'enable_solution',
    ];

    protected $casts = [
        'ai_features' => 'array',
        'enabled' => 'boolean',
        'enable_description' => 'boolean',
        'enable_reply' => 'boolean',
        'enable_solution' => 'boolean',
    ];
}
