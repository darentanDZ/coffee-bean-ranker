<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Bean extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
        'roaster',
        'origin_country',
        'origin_region',
        'farm',
        'altitude',
        'roast_level',
        'processing_method',
        'varietal',
        'harvest_date',
        'price',
        'bag_size_grams',
        'image_url',
        'description',
        'created_by_user_id',
        'verified',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'harvest_date' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Get the user who created this bean entry
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get all reviews for this bean
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all user beans (purchases) for this bean
     */
    public function userBeans(): HasMany
    {
        return $this->hasMany(UserBean::class);
    }

    /**
     * Get all brew logs for this bean
     */
    public function brewLogs(): HasMany
    {
        return $this->hasMany(BrewLog::class);
    }

    /**
     * Get flavor tags for this bean
     */
    public function flavorTags(): BelongsToMany
    {
        return $this->belongsToMany(FlavorTag::class, 'bean_flavor_tags');
    }

    /**
     * Get average rating for this bean
     */
    public function averageRating(): float
    {
        return $this->reviews()->avg('rating_overall') ?? 0;
    }

    /**
     * Get total review count
     */
    public function reviewCount(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Searchable fields for Laravel Scout
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'roaster' => $this->roaster,
            'origin_country' => $this->origin_country,
            'origin_region' => $this->origin_region,
            'description' => $this->description,
        ];
    }
}
