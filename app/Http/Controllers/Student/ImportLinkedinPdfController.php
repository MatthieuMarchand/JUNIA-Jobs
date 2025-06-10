<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Services\StudentProfileExtractors\LinkedinPdfExtractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;
use function now;
use function to_route;

class ImportLinkedinPdfController extends Controller
{
    use HasStudentProfile;

    public function __invoke(Request $request)
    {
        $studentProfile = $this->studentProfile();

        Gate::authorize('update', $studentProfile);

        $validated = $request->validate([
            "pdf" => "required|file|mimes:pdf",
        ]);

        try {
            $extractor = resolve(LinkedinPdfExtractor::class);
            $extracted = $extractor->extract($request->file("pdf")->getContent());

            $studentProfile->first_name = $extracted->firstName ?? '';
            $studentProfile->last_name = $extracted->lastName ?? '';
            $studentProfile->phone_number = $extracted->phoneNumber ?? '';
            $studentProfile->summary = $extracted->summary;

            $studentProfile->save();

            // Pas le plus optimisé, mais le nombre de compétences reste faible (<100 en général).
            // Donc, on peut se le permettre pour l'instant.
            foreach ($extracted->skills as $name) {
                Skill::firstOrCreate(['name' => $name]);
            }
            $studentProfile->skills()->sync($extracted->skills);

            $studentProfile->professionalExperiences()->delete();
            $studentProfile->academicRecords()->delete();

            foreach ($extracted->academicRecords as $academicRecord) {
                $studentProfile->academicRecords()->create([
                    'degree' => $academicRecord->degree ?? '',
                    'institution' => $academicRecord->institution ?? '',
                    'description' => $academicRecord->description ?? '',
                    'start' => $academicRecord->start ?? now(),
                    'end' => $academicRecord->end ?? now(),
                ]);
            }

            foreach ($extracted->professionalExperiences as $professionalExperience) {
                $studentProfile->professionalExperiences()->create([
                    'title' => $professionalExperience->title ?? '',
                    'contract_type' => $professionalExperience->contractType ?? '',
                    'company_name' => $professionalExperience->companyName ?? '',
                    'location' => $professionalExperience->location ?? '',
                    'start' => $professionalExperience->start ?? now(),
                    'end' => $professionalExperience->end ?? now(),
                    'description' => $professionalExperience->description ?? '',
                ]);
            }

            return to_route('students.profile.edit')
                ->with('success', 'Votre profil a été mis à jour avec succès.');
        } catch (Throwable $e) {
            return to_route('students.profile.edit')
                ->with('error', "Impossible d'importer ce PDF. Veuillez vous rapprocher de l'équipe technique pour qu'ils adaptent l'import.");
        }
    }
}
