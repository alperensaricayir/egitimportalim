<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'link',
        'image',
        'is_premium',
        'category',
        'instructor',
        'level',
        'starts_at',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'starts_at' => 'datetime',
    ];
}
