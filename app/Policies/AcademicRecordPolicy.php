<?php

namespace App\Policies;

use App\Models\AcademicRecord;
use App\Models\StudentProfile;
use App\Models\User;

class AcademicRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any', StudentProfile::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AcademicRecord $academicRecord): bool
    {
        return $user->can('view', $academicRecord->studentProfile);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create', StudentProfile::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AcademicRecord $academicRecord): bool
    {
        return $user->can('update', $academicRecord->studentProfile);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AcademicRecord $academicRecord): bool
    {
        return $user->can('delete', $academicRecord->studentProfile);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AcademicRecord $academicRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AcademicRecord $academicRecord): bool
    {
        return false;
    }
}
