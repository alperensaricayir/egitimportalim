<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order',
        'status',
        'published_at',
        'is_preview',
        'updated_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_preview' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function revisions()
    {
        return $this->hasMany(LessonRevision::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
