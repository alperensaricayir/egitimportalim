<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'is_paid',
        'price',
        'thumbnail',
        'status',
        'published_at',
        'updated_by',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function revisions()
    {
        return $this->hasMany(CourseRevision::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFilter($query, array $filters)
    {
        $query
            ->when($filters['q'] ?? null, fn($q, $qv) => $q->where('title', 'like', "%{$qv}%"))
            ->when(isset($filters['status']) && $filters['status'] !== '', fn($q) => $q->where('status', $filters['status']))
            ->when(isset($filters['paid']) && $filters['paid'] !== '', function ($q) use ($filters) {
                if ($filters['paid'] === 'paid') {
                    $q->where('is_paid', true);
                } elseif ($filters['paid'] === 'free') {
                    $q->where('is_paid', false);
                }
            })
            ->when($filters['sort'] ?? null, function ($q) use ($filters) {
                return match ($filters['sort']) {
                    'title_asc' => $q->orderBy('title', 'asc'),
                    'title_desc' => $q->orderBy('title', 'desc'),
                    default => $q->latest(),
                };
            }, fn($q) => $q->latest());
    }
}
