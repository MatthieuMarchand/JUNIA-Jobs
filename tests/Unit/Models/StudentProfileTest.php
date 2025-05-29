<?php

namespace Tests\Unit\Models;

use App\Models\AcademicRecord;
use App\Models\ProfessionalExperience;
use App\Models\StudentProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

class StudentProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_temporary_photo_url_expires_after_1_minute_for_privacy(): void
    {
        $profile = StudentProfile::factory()->withPhoto()->create();

        $publicPhotoUrl = $profile->temporaryPhotoUrl();
        $this->assertNotNull($publicPhotoUrl);
        $pictureResponse = $this->get($publicPhotoUrl);
        $pictureResponse->assertOk();

        $this->travelTo(now()->addMinutes(2));
        $pictureResponse = $this->get($publicPhotoUrl);
        $pictureResponse->assertForbidden();
    }

    public function test_academic_records_are_sorted_by_start_date(): void
    {
        $studentProfile = StudentProfile::factory()->create();

        $thirdRecord = AcademicRecord::factory()->for($studentProfile)->create([
            'start' => now()->subYears(3),
            'end' => now()->subYears(2),
        ]);

        $firstRecord = AcademicRecord::factory()->for($studentProfile)->create([
            'start' => now()->subYear(),
            'end' => now(),
        ]);

        $secondRecord = AcademicRecord::factory()->for($studentProfile)->create([
            'start' => now()->subYears(2),
            'end' => now()->subYear(),
        ]);

        $this->assertSame([
            $firstRecord->id,
            $secondRecord->id,
            $thirdRecord->id,
        ], $studentProfile->academicRecords()->pluck('id')->toArray());
    }

    public function test_professional_experiences_are_sorted_by_start_date(): void
    {
        $studentProfile = StudentProfile::factory()->create();

        $thirdExperience = ProfessionalExperience::factory()->for($studentProfile)->create([
            'start' => now()->subYears(3),
            'end' => now()->subYears(2),
        ]);

        $firstExperience = ProfessionalExperience::factory()->for($studentProfile)->create([
            'start' => now()->subYear(),
            'end' => now(),
        ]);

        $secondExperience = ProfessionalExperience::factory()->for($studentProfile)->create([
            'start' => now()->subYears(2),
            'end' => now()->subYear(),
        ]);

        $this->assertSame([
            $firstExperience->id,
            $secondExperience->id,
            $thirdExperience->id,
        ], $studentProfile->professionalExperiences()->pluck('id')->toArray());
    }
}
