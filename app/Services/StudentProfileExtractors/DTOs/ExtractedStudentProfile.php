<?php

namespace App\Services\StudentProfileExtractors\DTOs;

class ExtractedStudentProfile
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $summary = null,
        public ?string $phoneNumber = null,

        /** @var string[] * */
        public array $domains = [],

        /** @var string[] * */
        public array $skills = [],

        /** @var ExtractedAcademicRecord[] * */
        public array $academicRecords = [],

        /** @var ExtractedProfessionalExperience[] * */
        public array $professionalExperiences = [],
    ) {
    }
}
