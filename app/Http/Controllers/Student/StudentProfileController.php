<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Skill;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use function to_route;

class StudentProfileController extends Controller
{
    private function getStudentProfile(): StudentProfile
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

    public function show()
    {
        $studentProfile = $this->getStudentProfile();

        Gate::authorize('view', $studentProfile);

        return view('students.profile.show', [
            'studentProfile' => $studentProfile,
        ]);
    }

    public function edit()
    {
        $studentProfile = $this->getStudentProfile();
        Gate::authorize('update', $studentProfile);

        return view('students.profile.edit', [
            'studentProfile' => $studentProfile,
            'domains' => Domain::all(),
            'skills' => Skill::all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $studentProfile = $this->getStudentProfile();

        Gate::authorize('update', $studentProfile);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'phone_number' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'contract_type_ids' => ['nullable', 'array'],
            'contract_type_ids.*' => 'exists:contract_types,id',

            'skill_names' => ['nullable', 'array'],
            'skill_names.*' => 'string',

            'domain_names' => ['nullable', 'array'],
            'domain_names.*' => 'string',
        ]);

        $studentProfile->first_name = $validated['first_name'];
        $studentProfile->last_name = $validated['last_name'];
        $studentProfile->summary = $validated['summary'];
        $studentProfile->phone_number = $validated['phone_number'];

        if ($studentProfile->photo_path && $request->has('photo')) {
            Storage::delete($studentProfile->photo_path);
            $studentProfile->photo_path = null;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos');
            $studentProfile->photo_path = $path;
        }

        if ($request->has('contract_type_ids')) {
            $studentProfile->contractTypes()->sync($request->contract_type_ids);
        }

        if ($request->has('skill_names')) {
            // Pas le plus optimisé, mais le nombre de compétences reste faible (<100 en général).
            // Donc, on peut se le permettre pour l'instant.
            foreach ($request->skill_names as $name) {
                Skill::firstOrCreate(['name' => $name]);
            }

            $studentProfile->skills()->sync($request->skill_names);
        }

        if ($request->has('domain_names')) {
            // Pas le plus optimisé, mais le nombre de domaines reste faible (<100 en général).
            // Donc, on peut se le permettre pour l'instant.
            foreach ($request->domain_names as $name) {
                Domain::firstOrCreate(['name' => $name]);
            }

            $studentProfile->domains()->sync($request->domain_names);
        }

        $studentProfile->save();

        return to_route('students.profile.show')
            ->with('success', 'Profil mis à jour !');
    }
}
