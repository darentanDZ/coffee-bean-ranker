<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBean extends Model
{
    protected $fillable = [
        'user_id',
        'bean_id',
        'purchase_date',
        'purchase_location',
        'roast_date',
        'price_paid',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'roast_date' => 'date',
        'price_paid' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bean(): BelongsTo
    {
        return $this->belongsTo(Bean::class);
    }
}
