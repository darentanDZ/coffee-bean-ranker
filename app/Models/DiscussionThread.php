<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionThread extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'title',
        'content',
        // 'pinned' removed - admin only
        // 'locked' removed - admin only
        // 'view_count' removed - system managed
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'locked' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ThreadReply::class, 'thread_id');
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}
