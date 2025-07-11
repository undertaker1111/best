<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AILog extends Model
{
    protected $fillable = [
        'user_id',
        'feature',
        'action',
        'input',
        'output',
        'related_id',
        'related_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
