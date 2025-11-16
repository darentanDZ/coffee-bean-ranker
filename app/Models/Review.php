<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'bean_id',
        'rating_overall',
        'rating_aroma',
        'rating_acidity',
        'rating_body',
        'rating_flavor',
        'rating_aftertaste',
        'brewing_method',
        'review_text',
        'would_buy_again',
        'helpful_count',
    ];

    protected $casts = [
        'rating_overall' => 'decimal:1',
        'rating_aroma' => 'decimal:1',
        'rating_acidity' => 'decimal:1',
        'rating_body' => 'decimal:1',
        'rating_flavor' => 'decimal:1',
        'rating_aftertaste' => 'decimal:1',
        'would_buy_again' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bean(): BelongsTo
    {
        return $this->belongsTo(Bean::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReviewImage::class);
    }
}
