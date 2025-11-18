<?php

namespace App\Policies;

use App\Models\Bean;
use App\Models\User;

class BeanPolicy
{
    /**
     * Determine if the user can view any beans.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the bean.
     */
    public function view(?User $user, Bean $bean): bool
    {
        return true;
    }

    /**
     * Determine if the user can create beans.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the bean.
     */
    public function update(User $user, Bean $bean): bool
    {
        // User can update if they created it or they are an admin
        return $user->id === $bean->created_by_user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can delete the bean.
     */
    public function delete(User $user, Bean $bean): bool
    {
        // User can delete if they created it or they are an admin
        return $user->id === $bean->created_by_user_id || $user->isAdmin();
    }

    /**
     * Determine if the user can restore the bean.
     */
    public function restore(User $user, Bean $bean): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the bean.
     */
    public function forceDelete(User $user, Bean $bean): bool
    {
        return $user->isAdmin();
    }
}
