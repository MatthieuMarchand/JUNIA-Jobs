<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CompanyRegistrationRequest;
use App\Models\User;

class CompanyRegistrationRequestPolicy
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
    public function view(User $user, CompanyRegistrationRequest $companyRegistrationRequest): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyRegistrationRequest $companyRegistrationRequest): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyRegistrationRequest $companyRegistrationRequest): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CompanyRegistrationRequest $companyRegistrationRequest): bool
    {
        return $user->role === UserRole::Administrator;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CompanyRegistrationRequest $companyRegistrationRequest): bool
    {
        return $user->role === UserRole::Administrator;
    }
}
