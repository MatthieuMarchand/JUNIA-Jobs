<?php

namespace App\Http\Controllers\Student;

use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;

trait HasStudentProfile
{
    private function studentProfile(): StudentProfile
    {
        // Si pas de studentProfile existant en bdd, on en instancie un à la volée (il n'est pas créé en bdd, seulement en php).
        // Comme ça la vue reçoit toujours un studentProfile non null
        return Auth::user()
            ->studentProfile()
            ->with('academicRecords')
            ->with('skills')
            ->with('professionalExperiences')
            ->firstOrNew();
    }
}
