<?php

namespace App\Policies;

use App\Models\DiscussionThread;
use App\Models\User;

class DiscussionThreadPolicy
{
    /**
     * Determine if the user can view any discussion threads.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the discussion thread.
     */
    public function view(?User $user, DiscussionThread $thread): bool
    {
        return true;
    }

    /**
     * Determine if the user can create discussion threads.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the discussion thread.
     */
    public function update(User $user, DiscussionThread $thread): bool
    {
        // User can update if they created it, or they are admin/moderator
        return $user->id === $thread->user_id || $user->isModerator();
    }

    /**
     * Determine if the user can delete the discussion thread.
     */
    public function delete(User $user, DiscussionThread $thread): bool
    {
        // User can delete if they created it, or they are admin/moderator
        return $user->id === $thread->user_id || $user->isModerator();
    }

    /**
     * Determine if the user can restore the discussion thread.
     */
    public function restore(User $user, DiscussionThread $thread): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the discussion thread.
     */
    public function forceDelete(User $user, DiscussionThread $thread): bool
    {
        return $user->isAdmin();
    }
}
