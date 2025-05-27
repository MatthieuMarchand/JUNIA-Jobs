<?php

namespace App\Services\StudentProfileExtractors\DTOs;

use Carbon\Carbon;

class ExtractedAcademicRecord
{
    public function __construct(
        public ?string $degree = null,
        public ?string $institution = null,
        public ?Carbon $start = null,
        public ?Carbon $end = null,
        public ?string $description = null,
    ) {
    }
}
