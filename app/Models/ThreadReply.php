<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThreadReply extends Model
{
    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
        // 'is_best_answer' removed - thread author only
        // 'upvotes' removed - system managed
    ];

    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(DiscussionThread::class, 'thread_id');
    }
}
