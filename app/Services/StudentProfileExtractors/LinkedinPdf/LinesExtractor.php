<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf;

use App\Services\StudentProfileExtractors\LinkedinPdf\DTOs\LineDto;
use Illuminate\Support\Str;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;

class LinesExtractor
{
    /**
     * @return LineDto[]
     */
    public function extract(string $pdfContent): array
    {
        $config = new Config();
        // Pour avoir les font-size
        $config->setDataTmFontInfoHasToBeIncluded(true);

        $parser = new Parser([], $config);
        $pdf = $parser->parseContent($pdfContent);

        $paginationFontSize = 9.0;

        /** @var LineDto[] $lines */
        $lines = [];
        foreach ($pdf->getPages() as $page) {
            foreach ($page->getDataTm() as $tm) {
                $text = Str::deduplicate(Str::replace("\u{A0}", "", $tm[1]), "\n");
                $fontSize = (float) $tm[3];

                // On ne veut pas de lignes vides ni de pagination
                if ($text === "" || $fontSize === $paginationFontSize) {
                    continue;
                }

                $lines[] = new LineDto(
                    text: $text,
                    fontSize: $fontSize
                );
            }
        }

        return $lines;
    }
}
