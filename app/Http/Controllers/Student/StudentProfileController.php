<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use function to_route;

class StudentProfileController extends Controller
{
    // Permet de récupérer tous les profils étudiant
    public function index()
    {
        Gate::authorize('viewAny', StudentProfile::class);
        $students = StudentProfile::all();

        return view('students.profiles.index', compact('students'));
    }

    private function getStudentProfile(): StudentProfile
    {
        // Si pas de studentProfile existant en bdd, on en instancie un à la volée (il n'est pas créé en bdd, seulement en php).
        // Comme ça la vue reçoit toujours un studentProfile non null
        return Auth::user()->studentProfile()->firstOrNew();
    }

    public function show()
    {
        $studentProfile = $this->getStudentProfile();

        Gate::authorize('view', $studentProfile);

        return view('students.profile', [
            'studentProfile' => $studentProfile,
        ]);
    }

    public function edit()
    {
        $studentProfile = $this->getStudentProfile();

        Gate::authorize('update', $studentProfile);

        return view('students.profile', [
            'studentProfile' => $studentProfile,
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
            'research_area_ids' => ['nullable', 'array'],
            'research_area_ids.*' => 'exists:research_areas,id',
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

        if ($request->has('research_area_ids')) {
            $studentProfile->researchAreas()->sync($request->research_area_ids);
        }

        $studentProfile->save();

        return to_route('students.profile.show');
    }
}
