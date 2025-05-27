<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf;

use App\Services\StudentProfileExtractors\DTOs\ExtractedAcademicRecord;
use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;
use Carbon\Carbon;
use Illuminate\Support\Str;
use function explode;
use function preg_match;

class AcademicRecordExtractor
{
    // Regex pour capturer les dates de début et de fin des formations
    // "·(2016-2018)" à "· (septembre 2016-octobre 2018)"
    // Il y a deux groupes capturant le début et la fin de la période : avant et après le tiret
    private string $recordDatesRegex = "/·\s?\((\w*\s?\d{4})-(\w*\s?\d{4})\)/u";

    /**
     * @param LineDto[] $lines
     *
     * @return ExtractedAcademicRecord[]
     */
    public function extract(array $lines): array
    {
        $institutionFontSize = 12.0;

        $records = [];
        $record = new ExtractedAcademicRecord();
        $description = "";

        $lastIndex = count($lines) - 1;

        foreach ($lines as $index => $line) {
            if ($line->fontSize === $institutionFontSize) {
                $record->institution = $line->text;
                continue;
            }

            $description .= $line->text . " ";

            $isLastLine = $index === $lastIndex;
            $nextLineIsInstitution = isset($lines[$index + 1]) && $lines[$index + 1]->fontSize === $institutionFontSize;
            if ($isLastLine || $nextLineIsInstitution) {
                $exploded = explode(',', $description, 2);

                // Dans le cas où il n'y a pas de description, on a pas de degree
                if (isset($exploded[1])) {
                    $record->degree = $exploded[0];
                }
                // Si pas de virgule, on considère que la description est dans le premier élément
                $descriptionWithDates = $exploded[1] ?? $exploded[0];
                $record->description = Str::trim(Str::replaceMatches($this->recordDatesRegex, "", $descriptionWithDates));

                $dates = $this->extractDates($descriptionWithDates);
                $record->start = $dates['start'];
                $record->end = $dates['end'];

                $records[] = $record;
                $record = new ExtractedAcademicRecord();
                $description = "";
            }
        }

        return $records;
    }

    private function extractDates(string $text): array
    {
        $dates = [
            'start' => null,
            'end' => null,
        ];

        $matches = [];
        if (preg_match($this->recordDatesRegex, $text, $matches) === 1) {
            // Il peut n'y avoir que l'année ou le mois et l'année
            if (str_contains($matches[1], " ")) {
                $dates['start'] = Carbon::createFromLocaleFormat("F Y", "fr", $matches[1])?->startOfMonth();
            } else {
                $dates['start'] = Carbon::createFromLocaleFormat("Y", "fr", $matches[1])?->startOfYear();
            }

            // Pareil pour la fin
            if (str_contains($matches[2], " ")) {
                $dates['end'] = Carbon::createFromLocaleFormat("F Y", "fr", $matches[2])?->startOfMonth();
            } else {
                $dates['end'] = Carbon::createFromLocaleFormat("Y", "fr", $matches[2])?->startOfYear();
            }
        }

        return $dates;
    }
}
