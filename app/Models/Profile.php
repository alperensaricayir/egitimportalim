<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'city',
        'country',
        'skills',
        'website_url',
        'linkedin_url',
        'github_url',
        'instagram_url',
        'youtube_url',
        'x_url',
        'behance_url',
        'dribbble_url',
        'avatar_path',
        'is_public',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_public' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
