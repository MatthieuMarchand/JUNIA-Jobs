<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\CompanyInviteStudent;
use App\Models\User;

class CompanyInviteStudentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Company && $user->companyProfile !== null;
    }

    public function viewAsStudent(User $user): bool
    {
        return $user->role === UserRole::Student && $user->studentProfile !== null;
    }

    public function view(User $user, CompanyInviteStudent $invitation): bool
    {
        // Limiter les invitations à son entreprise uniquement
        return $user->role === UserRole::Company &&
               $user->companyProfile !== null &&
               $invitation->company_profile_id === $user->companyProfile->id;
    }

    public function viewStudent(User $user, CompanyInviteStudent $invitation): bool
    {
        // Limiter les invitations à son profil étudiant uniquement
        return $user->role === UserRole::Student &&
               $user->studentProfile !== null &&
               $invitation->student_profile_id === $user->studentProfile->id;
    }
}
