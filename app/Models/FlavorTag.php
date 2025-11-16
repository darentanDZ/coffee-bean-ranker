<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FlavorTag extends Model
{
    protected $fillable = [
        'name',
        'category',
    ];

    public function beans(): BelongsToMany
    {
        return $this->belongsToMany(Bean::class, 'bean_flavor_tags');
    }
}
