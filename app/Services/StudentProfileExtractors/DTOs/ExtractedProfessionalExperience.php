<?php

namespace App\Services\StudentProfileExtractors\DTOs;

use Carbon\Carbon;

class ExtractedProfessionalExperience
{
    public function __construct(
        public ?string $title = null,
        public ?string $contractType = null,
        public ?string $companyName = null,
        public ?string $location = null,
        public ?Carbon $start = null,
        public ?Carbon $end = null,
        public ?string $description = null,
    ) {
    }
}
