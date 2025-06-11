<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Models\Domain;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use function to_route;

class StudentProfileController extends Controller
{
    use HasStudentProfile;

    public function show()
    {
        $studentProfile = $this->studentProfile();

        Gate::authorize('view', $studentProfile);

        return view('students.profile.show', [
            'studentProfile' => $studentProfile,
        ]);
    }

    public function edit()
    {
        $studentProfile = $this->studentProfile();
        Gate::authorize('update', $studentProfile);

        return view('students.profile.edit', [
            'studentProfile' => $studentProfile,
            'domains' => Domain::all(),
            'skills' => Skill::all(),
            'contractTypes' => ContractType::all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $studentProfile = $this->studentProfile();

        Gate::authorize('update', $studentProfile);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'phone_number' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'driver_license' => 'boolean',
            'vehicle' => 'boolean',

            'contract_preferences' => ['nullable', 'array'],
            'contract_preferences.*.contract_type_id' => 'required|exists:contract_types,id',
            'contract_preferences.*.contract_duration' => 'nullable|string|max:255',
            'contract_preferences.*.work_study_rhythm' => 'nullable|string|max:255',

            'skill_names' => ['nullable', 'array'],
            'skill_names.*' => 'string',

            'domain_names' => ['nullable', 'array'],
            'domain_names.*' => 'string',

            'hobbies' => ['nullable', 'array'],
            'hobbies.*' => 'string|max:255',

            'certifications' => ['nullable', 'array'],
            'certifications.*.title' => 'required|string|max:255',
            'certifications.*.date_obtained' => 'required|date',
            'certifications.*.description' => 'nullable|string',
            'certifications.*.link' => 'nullable|url',
        ]);

        // Update basic fields
        $studentProfile->fill([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'summary' => $validated['summary'],
            'phone_number' => $validated['phone_number'],
            'driver_license' => $validated['driver_license'] ?? false,
            'vehicle' => $validated['vehicle'] ?? false,
        ]);

        // Handle photo upload
        if ($studentProfile->photo_path && $request->has('photo')) {
            Storage::delete($studentProfile->photo_path);
            $studentProfile->photo_path = null;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos');
            $studentProfile->photo_path = $path;
        }

        $studentProfile->save();

        // Handle contract preferences with pivot data
        if ($request->has('contract_preferences')) {
            $syncData = [];
            foreach ($validated['contract_preferences'] as $preference) {
                $syncData[$preference['contract_type_id']] = [
                    'contract_duration' => $preference['contract_duration'] ?? null,
                    'work_study_rhythm' => $preference['work_study_rhythm'] ?? null,
                ];
            }
            $studentProfile->contractTypes()->sync($syncData);
        }

        // Handle skills
        if ($request->has('skill_names')) {
            foreach ($validated['skill_names'] as $name) {
                Skill::firstOrCreate(['name' => $name]);
            }
            $studentProfile->skills()->sync($validated['skill_names']);
        }

        // Handle domains
        if ($request->has('domain_names')) {
            foreach ($validated['domain_names'] as $name) {
                Domain::firstOrCreate(['name' => $name]);
            }
            $studentProfile->domains()->sync($validated['domain_names']);
        }

        // Handle hobbies
        if ($request->has('hobbies')) {
            $studentProfile->hobbies()->delete();
            foreach ($validated['hobbies'] as $hobby) {
                $studentProfile->hobbies()->create(['hobby_name' => $hobby]);
            }
        }

        // Handle certifications
        if ($request->has('certifications')) {
            $studentProfile->certifications()->delete();
            foreach ($validated['certifications'] as $certification) {
                $studentProfile->certifications()->create($certification);
            }
        }

        return to_route('students.profile.show')
            ->with('success', 'Profil mis à jour !');
    }
}
