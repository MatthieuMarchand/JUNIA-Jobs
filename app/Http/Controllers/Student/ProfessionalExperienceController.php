<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use function to_route;

class ProfessionalExperienceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', ProfessionalExperience::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', ProfessionalExperience::class);

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "contract_type" => "required|string|max:255",
            "company_name" => "required|string|max:255",
            "location" => "nullable|string|max:255",
            "start" => "required|date",
            "end" => "nullable|date|after_or_equal:start",
            "description" => "nullable|string|max:1000",
        ]);

        $request->user()->studentProfile->professionalExperiences()->create($validated);

        return to_route('students.profile.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfessionalExperience $professionalExperience)
    {
        Gate::authorize('view', $professionalExperience);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfessionalExperience $professionalExperience)
    {
        Gate::authorize('update', $professionalExperience);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfessionalExperience $professionalExperience)
    {
        Gate::authorize('update', $professionalExperience);

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "contract_type" => "required|string|max:255",
            "company_name" => "required|string|max:255",
            "location" => "nullable|string|max:255",
            "start" => "required|date",
            "end" => "nullable|date|after_or_equal:start",
            "description" => "nullable|string|max:1000",
        ]);

        $professionalExperience->update($validated);

        return to_route('students.profile.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfessionalExperience $professionalExperience)
    {
        Gate::authorize('delete', $professionalExperience);

        $professionalExperience->delete();

        return to_route('students.profile.show');
    }
}
