<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf;

use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;

class SummaryExtractor
{
    /**
     * @param LineDto[] $lines
     */
    public function extract(array $lines): string
    {
        $summary = "";
        foreach ($lines as $line) {
            if (str_starts_with($line->text, "- ")) {
                $summary .= "\n";
            }
            $summary .= $line->text . " ";
        }

        return $summary;
    }
}
