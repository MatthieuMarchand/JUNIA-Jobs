<?php

namespace App\Services\StudentProfileExtractors;

use App\Services\StudentProfileExtractors\DTOs\ExtractedStudentProfile;
use App\Services\StudentProfileExtractors\LinkedinPdf\AcademicRecordExtractor;
use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;
use App\Services\StudentProfileExtractors\LinkedinPdf\LinesExtractor;
use App\Services\StudentProfileExtractors\LinkedinPdf\ProfessionalExperiencesExtractor;
use App\Services\StudentProfileExtractors\LinkedinPdf\SectionsLinesExtractor;
use App\Services\StudentProfileExtractors\LinkedinPdf\SummaryExtractor;
use Illuminate\Support\Str;
use function array_map;
use function explode;

class LinkedinPdfExtractor
{
    public function __construct(
        private readonly LinesExtractor $linesExtractor,
        private readonly SectionsLinesExtractor $sectionsLinesExtractor,
        private readonly SummaryExtractor $summaryExtractor,
        private readonly ProfessionalExperiencesExtractor $professionalExperiencesExtractor,
        private readonly AcademicRecordExtractor $academicRecordExtractor,
    ) {
    }

    public function extract(string $pdfContent): ExtractedStudentProfile
    {
        $profile = new ExtractedStudentProfile();

        $lines = $this->linesExtractor->extract($pdfContent);
        $sectionLines = $this->sectionsLinesExtractor->extract($lines);

        if (isset($sectionLines->name[0])) {
            [$firstName, $lastName] = explode(" ", $sectionLines->name[0]->text);

            $profile->firstName = Str::limit($firstName, 255);
            $profile->lastName = Str::limit($lastName, 255);
        }

        $profile->summary = Str::limit($this->summaryExtractor->extract($sectionLines->summary), 1000);

        $profile->skills = array_map(fn(LineDto $line) => $line->text, $sectionLines->skills);

        $profile->academicRecords = $this->academicRecordExtractor->extract($sectionLines->academicRecords);

        $profile->professionalExperiences = $this->professionalExperiencesExtractor->extract($sectionLines->professionalExperiences);

        return $profile;
    }
}
