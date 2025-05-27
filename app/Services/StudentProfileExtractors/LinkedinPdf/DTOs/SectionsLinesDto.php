<?php

namespace App\Services\StudentProfileExtractors\LinkedinPdf\DTOs;

class SectionsLinesDto
{
    public function __construct(
        /** @var LineDto[] */
        public array $name = [],

        /** @var LineDto[] */
        public array $summary = [],

        /** @var LineDto[] */
        public array $skills = [],

        /** @var LineDto[] */
        public array $academicRecords = [],

        /** @var LineDto[] */
        public array $professionalExperiences = [],
    ) {
    }
}
