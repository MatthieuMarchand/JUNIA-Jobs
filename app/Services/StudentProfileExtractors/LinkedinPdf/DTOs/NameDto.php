<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf\DTOs;

class NameDto
{
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {
    }
}
