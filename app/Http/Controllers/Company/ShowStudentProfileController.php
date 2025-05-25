<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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

        // Log::info('Affichage profil étudiant', [
        //     'id' => $studentProfile->id,
        //     'nom' => $studentProfile->first_name.' '.$studentProfile->last_name,
        //     'relations_chargées' => [
        //         'domains' => $studentProfile->domains->count(),
        //         'skills' => $studentProfile->skills->count(),
        //         'contract_types' => $studentProfile->contractTypes->count(),
        //         'experiences' => $studentProfile->professionalExperiences->count(),
        //     ],
        // ]);

        return view('students.profiles.show', [
            'student' => $studentProfile,
        ]);
    }
}
