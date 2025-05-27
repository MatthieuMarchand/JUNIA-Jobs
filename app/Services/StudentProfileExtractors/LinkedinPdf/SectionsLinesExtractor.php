<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf;

use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;
use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\SectionsLinesDto;
use App\Utils\ArrayUtils;
use function array_slice;
use function count;

class SectionsLinesExtractor
{
    /**
     * @param LineDto[] $lines
     */
    public function extract(array $lines): SectionsLinesDto
    {
        $sectionsLines = new SectionsLinesDto();

        $nameStart = ArrayUtils::findKeyByCallback($lines, fn(LineDto $line) => $line->fontSize === 26.0);
        if (isset($lines[$nameStart])) {
            $sectionsLines->name[] = $lines[$nameStart];
        }

        $skillsStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Principales compétences' && $line->fontSize === 13.0
        );

        $languagesStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Languages' && $line->fontSize === 13.0
        );

        $certificationsStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Certifications' && $line->fontSize === 13.0
        );

        $professionalExperiencesStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Expérience' && $line->fontSize === 15.75
        );

        $skillsEnd = $languagesStart ?? $certificationsStart ?? $nameStart;
        $sectionsLines->skills = array_slice($lines, $skillsStart + 1, $skillsEnd - ($skillsStart + 1));

        $summaryStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Résumé' && $line->fontSize === 15.75
        );
        $summaryEnd = $professionalExperiencesStart;
        $sectionsLines->summary = array_slice($lines, $summaryStart + 1, $summaryEnd - ($summaryStart + 1));

        $academicRecordsStart = ArrayUtils::findKeyByCallback(
            $lines,
            fn(LineDto $line) => $line->text === 'Formation' && $line->fontSize === 15.75
        );
        $academicRecordsEnd = count($lines);
        $sectionsLines->academicRecords = array_slice($lines, $academicRecordsStart + 1, $academicRecordsEnd - ($academicRecordsStart + 1));

        $professionalExperiencesEnd = $academicRecordsStart;
        $sectionsLines->professionalExperiences = array_slice($lines, $professionalExperiencesStart + 1,
            $professionalExperiencesEnd - ($professionalExperiencesStart + 1));

        return $sectionsLines;
    }
}
