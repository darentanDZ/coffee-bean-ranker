<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrewLog extends Model
{
    protected $fillable = [
        'user_id',
        'bean_id',
        'brewing_method',
        'grind_size',
        'water_temp',
        'brew_time',
        'ratio',
        'notes',
        'rating',
        'image_url',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];

    /**
     * Get the user that owns the brew log
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bean for this brew log
     */
    public function bean(): BelongsTo
    {
        return $this->belongsTo(Bean::class);
    }
}
