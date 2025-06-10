<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Gate;

class ShowStudentProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StudentProfile $studentProfile)
    {
        Gate::authorize('viewAny', StudentProfile::class);

        $studentProfile->load(['user']);
        $studentProfile->load([
            'domains',
            'skills',
            'contractTypes',
            'professionalExperiences' => function ($query) {
                $query->orderBy('start', 'desc');
            },
        ]);

        return view('companies.students.show', [
            'student' => $studentProfile,
        ]);
    }
}
