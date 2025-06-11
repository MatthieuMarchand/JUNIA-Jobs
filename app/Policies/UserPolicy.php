<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $loggedUser, User $user): bool
    {
        return $loggedUser->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $loggedUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $loggedUser, User $user): bool
    {
        return $loggedUser->id === $user->id
            || $loggedUser->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $loggedUser, User $user): bool
    {
        return $loggedUser->id === $user->id
            || $loggedUser->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $loggedUser, User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $loggedUser, User $user): bool
    {
        return false;
    }
}
