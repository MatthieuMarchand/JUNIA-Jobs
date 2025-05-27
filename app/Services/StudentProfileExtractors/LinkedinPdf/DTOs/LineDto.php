<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf\DTOs;

class LineDto
{
    public function __construct(
        public string $text,
        public float $fontSize
    ) {
    }
}
