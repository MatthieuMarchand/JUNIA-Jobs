<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use function to_route;

class AcademicRecordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', AcademicRecord::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', AcademicRecord::class);

        $validated = $request->validate([
            "degree" => "required|string|max:255",
            "institution" => "required|string|max:255",
            "start" => "required|date",
            "end" => "nullable|date|after_or_equal:start",
            "description" => "nullable|string|max:1000",
        ]);

        $request->user()->studentProfile->academicRecords()->create($validated);

        return to_route('students.profile.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicRecord $academicRecord)
    {
        Gate::authorize('view', $academicRecord);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicRecord $academicRecord)
    {
        Gate::authorize('update', $academicRecord);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicRecord $academicRecord): RedirectResponse
    {
        Gate::authorize('update', $academicRecord);

        $validated = $request->validate([
            "degree" => "required|string|max:255",
            "institution" => "required|string|max:255",
            "start" => "required|date",
            "end" => "nullable|date|after_or_equal:start",
            "description" => "nullable|string|max:1000",
        ]);

        $academicRecord->update($validated);

        return to_route('students.profile.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicRecord $academicRecord): RedirectResponse
    {
        Gate::authorize('delete', $academicRecord);

        $academicRecord->delete();

        return to_route('students.profile.show');
    }
}
