<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\StudentProfile;
use App\Services\StudentProfileExtractors\LinkedinPdfExtractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Throwable;
use function now;
use function to_route;

class ImportLinkedinPdfController extends Controller
{
    private function getStudentProfile(): StudentProfile
    {
        // Si pas de studentProfile existant en bdd, on en instancie un à la volée (il n'est pas créé en bdd, seulement en php).
        // Comme ça la vue reçoit toujours un studentProfile non null
        return Auth::user()->studentProfile()->firstOrNew();
    }

    public function __invoke(Request $request)
    {
        $studentProfile = $this->getStudentProfile();

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

            return to_route('students.profile.show')
                ->with('success', 'Votre profil a été mis à jour avec succès.');
        } catch (Throwable $e) {
            return to_route('students.profile.show')
                ->with('error', "Impossible d'importer ce PDF. Veuillez vous rapprocher de l'équipe technique pour qu'ils adaptent l'import.");
        }
    }
}
