<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine if the user can view any reviews.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the review.
     */
    public function view(?User $user, Review $review): bool
    {
        return true;
    }

    /**
     * Determine if the user can create reviews.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        // User can update if they created it or they are an admin
        return $user->id === $review->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // User can delete if they created it or they are an admin
        return $user->id === $review->user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can restore the review.
     */
    public function restore(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the review.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }
}
