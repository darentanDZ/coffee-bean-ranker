<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
        'brewing_preferences',
        'instagram_handle',
        'twitter_handle',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'brewing_preferences' => 'array',
        ];
    }

    /**
     * Get beans created by this user
     */
    public function createdBeans(): HasMany
    {
        return $this->hasMany(Bean::class, 'created_by_user_id');
    }

    /**
     * Get user's coffee collection (purchased beans)
     */
    public function beans(): HasMany
    {
        return $this->hasMany(UserBean::class);
    }

    /**
     * Get user's reviews
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get user's brew logs
     */
    public function brewLogs(): HasMany
    {
        return $this->hasMany(BrewLog::class);
    }

    /**
     * Get user's discussion threads
     */
    public function threads(): HasMany
    {
        return $this->hasMany(DiscussionThread::class);
    }

    /**
     * Get user's thread replies
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ThreadReply::class);
    }

    /**
     * Get users that this user is following
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Get users that are following this user
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a moderator or admin
     */
    public function isModerator(): bool
    {
        return in_array($this->role, ['moderator', 'admin']);
    }
}
