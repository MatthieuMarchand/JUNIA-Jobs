<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf;

use App\Services\StudentProfileExtractors\DTOs\ExtractedProfessionalExperience;
use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;
use Carbon\Carbon;
use Illuminate\Support\Str;
use function count;
use function preg_match;
use function str_starts_with;

class ProfessionalExperiencesExtractor
{
    // Regex pour capturer les dates de début et de fin des formations
    // "septembre 2016-octobre 2018 (11 mois)" à "septembre 2016-Present (4 ans)"
    // Il y a deux groupes capturant le début et la fin de la période : avant et après le tiret
    private string $experienceDatesRegex = "/(\w*\s?\d{4})-(?:(\w*\s?\d{4})|Present)/u";

    // Regex pour capturer la durée de l'expérience
    // Ex:
    // "(1 an 2 mois)"
    // "(1 mois)"
    // "(12 ans)"
    private string $durationRegex = "/\((?:\d+ ans?)?\s?(?:\d+ mois)?\)/";

    /**
     * @param LineDto[] $lines
     *
     * @return ExtractedProfessionalExperience[]
     */
    public function extract(array $lines): array
    {
        $companyNameFontSize = 12.0;
        $jobTitleFontSize = 11.5;
        $descriptionFontSize = 10.5;

        $experiences = [];
        $experience = new ExtractedProfessionalExperience();
        $jobTitleIndex = null;
        $description = "";

        $lastIndex = count($lines) - 1;

        foreach ($lines as $index => $line) {
            if ($line->fontSize === $companyNameFontSize) {
                $experience->companyName = $line->text;
                continue;
            }

            if ($line->fontSize === $jobTitleFontSize) {
                $jobTitleIndex = $index;
                $experience->title = $line->text;
                continue;
            }

            if ($line->fontSize === $descriptionFontSize && $jobTitleIndex !== null) {
                if ($index - $jobTitleIndex === 3) {
                    // Si on a deux lignes entre le job title et la description, on considère que la première est le lieu
                    $experience->location = $line->text;
                } else {
                    // Sinon, on considère que c'est la description
                    if (str_starts_with($line->text, "- ")) {
                        $description .= "\n";
                    }
                    $description .= $line->text . " ";
                }
            }

            $isLastLine = $index === $lastIndex;
            $nextLineIsCompanyName = isset($lines[$index + 1]) && $lines[$index + 1]->fontSize === $companyNameFontSize;
            $nextLineIsJobTitle = isset($lines[$index + 1]) && $lines[$index + 1]->fontSize === $jobTitleFontSize;
            if ($isLastLine || $nextLineIsCompanyName || ($nextLineIsJobTitle && $jobTitleIndex !== null)) {
                $experience->description = Str::replaceMatches(
                    $this->experienceDatesRegex, "", $description
                );
                $experience->description = Str::replaceMatches(
                    $this->durationRegex, "", $experience->description
                );
                $experience->description = Str::trim($experience->description);

                $dates = $this->extractDates($description);
                $experience->start = $dates['start'];
                $experience->end = $dates['end'];

                $companyName = $experience->companyName;
                $experiences[] = $experience;
                $experience = new ExtractedProfessionalExperience(
                    companyName: $companyName // On garde le nom si la prochaine expérience est dans la même entreprise
                );
                $foundJobTitle = false;
                $description = "";
            }
        }

        return $experiences;
    }

    private function extractDates(string $text): array
    {
        $dates = [
            'start' => null,
            'end' => null,
        ];

        $matches = [];
        if (preg_match($this->experienceDatesRegex, $text, $matches) === 1) {
            // Il peut n'y avoir que l'année ou le mois et l'année
            if (str_contains($matches[1], " ")) {
                $dates['start'] = Carbon::createFromLocaleFormat("F Y", "fr", $matches[1])?->startOfMonth();
            } else {
                $dates['start'] = Carbon::createFromLocaleFormat("Y", "fr", $matches[1])?->startOfYear();
            }

            // Pareil pour la fin
            if (isset($matches[2])) {
                if (str_contains($matches[2], " ")) {
                    $dates['end'] = Carbon::createFromLocaleFormat("F Y", "fr", $matches[2])?->startOfMonth();
                } else {
                    $dates['end'] = Carbon::createFromLocaleFormat("Y", "fr", $matches[2])?->startOfYear();
                }
            }
        }

        return $dates;
    }
}
