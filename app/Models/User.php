<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'phone',
        'city',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdminOrEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor'], true);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdminOrEditor();
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function likesGiven()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function likesReceived()
    {
        return $this->hasMany(Like::class, 'liked_user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('active', true)->latestOfMany();
    }

    public function isPremium(): bool
    {
        $sub = $this->activeSubscription;
        if (!$sub) {
            return false;
        }
        $plan = $sub->plan;
        return $plan?->is_premium === true;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }
}
