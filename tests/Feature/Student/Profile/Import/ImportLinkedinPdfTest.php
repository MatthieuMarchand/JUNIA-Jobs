<?php

namespace Tests\Feature\Student\Profile\Import;

use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentProfileExtractors\DTOs\ExtractedAcademicRecord;
use App\Services\StudentProfileExtractors\DTOs\ExtractedProfessionalExperience;
use App\Services\StudentProfileExtractors\DTOs\ExtractedStudentProfile;
use App\Services\StudentProfileExtractors\LinkedinPdfExtractor;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;
use function now;

class ImportLinkedinPdfTest extends TestCase
{
    use RefreshDatabase;

    private function createFilledPdfMock(): ExtractedStudentProfile
    {
        $expected = new ExtractedStudentProfile(
            firstName: "John",
            lastName: "Doe",
            summary: "Développeur web passionné par les technologies modernes.",
            phoneNumber: null,
            skills: ["PHP", "Laravel", "JavaScript", "Vue.js"],
            academicRecords: [
                new ExtractedAcademicRecord(
                    degree: "Diplôme d'ingénieur",
                    institution: "JUNIA ISEN Bordeaux",
                    start: now()->subYears(3),
                    end: now(),
                    description: "Électronique, maths, informatique, gestion de projet."
                ),
            ],
            professionalExperiences: [
                new ExtractedProfessionalExperience(
                    title: "Développeur web",
                    contractType: "CDI",
                    companyName: "Tech Company",
                    location: "Bordeaux",
                    start: now()->subYears(2),
                    end: now(),
                    description: "Développement d'applications web avec Laravel et Vue.js."
                ),
            ]
        );

        $this->mock(LinkedinPdfExtractor::class, function (MockInterface $mock) use ($expected) {
            $mock->expects('extract')->andReturn($expected);
        });

        return $expected;
    }

    private function createEmptyPdfMock(): ExtractedStudentProfile
    {
        $expected = new ExtractedStudentProfile(
            academicRecords: [
                new ExtractedAcademicRecord(),
            ],
            professionalExperiences: [
                new ExtractedProfessionalExperience(),
            ],
        );

        $this->mock(LinkedinPdfExtractor::class, function (MockInterface $mock) use ($expected) {
            $mock->expects('extract')->andReturn($expected);
        });

        return $expected;
    }

    public function test_import_will_update_profile(): void
    {
        $expected = $this->createFilledPdfMock();

        $profile = StudentProfile::factory()->create();

        $response = $this->actingAs($profile->user)->post('/students/profile/import/linkedin', [
            'pdf' => UploadedFile::fake()->create('linkedin.pdf'),
        ]);

        $response->assertRedirect('/students/profile');
        $response->assertSessionHas('success', 'Votre profil a été mis à jour avec succès.');

        $profile->refresh();

        $this->assertSame($expected->firstName, $profile->first_name);
        $this->assertSame($expected->lastName, $profile->last_name);
        $this->assertSame($expected->summary, $profile->summary);
        $this->assertSame('', $profile->phone_number);
        $this->assertSame($expected->skills, $profile->skills->pluck('name')->toArray());

        $this->assertCount(1, $profile->academicRecords);
        $record = $profile->academicRecords->first();
        $expectedRecord = $expected->academicRecords[0];
        $this->assertSame($expectedRecord->degree, $record->degree);
        $this->assertSame($expectedRecord->institution, $record->institution);
        $this->assertSame($expectedRecord->start->toDateString(), $record->start->toDateString());
        $this->assertSame($expectedRecord->end->toDateString(), $record->end->toDateString());
        $this->assertSame($expectedRecord->description, $record->description);

        $this->assertCount(1, $profile->professionalExperiences);
        $experience = $profile->professionalExperiences->first();
        $expectedExperience = $expected->professionalExperiences[0];
        $this->assertSame($expectedExperience->title, $experience->title);
        $this->assertSame($expectedExperience->contractType, $experience->contract_type);
        $this->assertSame($expectedExperience->companyName, $experience->company_name);
        $this->assertSame($expectedExperience->location, $experience->location);
        $this->assertSame($expectedExperience->start->toDateString(), $experience->start->toDateString());
        $this->assertSame($expectedExperience->end->toDateString(), $experience->end->toDateString());
        $this->assertSame($expectedExperience->description, $experience->description);
    }

    public function test_failed_import_is_notified(): void
    {
        $this->mock(LinkedinPdfExtractor::class, function (MockInterface $mock) {
            $mock->expects('extract')->andThrow(new Exception('error'));
        });

        $profile = StudentProfile::factory()->create();

        $response = $this->actingAs($profile->user)->post('/students/profile/import/linkedin', [
            'pdf' => UploadedFile::fake()->create('linkedin.pdf'),
        ]);

        $response->assertRedirect('/students/profile');
        $response->assertSessionHas('error',
            "Impossible d'importer ce PDF. Veuillez vous rapprocher de l'équipe technique pour qu'ils adaptent l'import.");
    }

    public function test_handle_empty_data(): void
    {
        $this->freezeTime(function () {
            $expected = $this->createEmptyPdfMock();

            $profile = StudentProfile::factory()->create();

            $response = $this->actingAs($profile->user)->post('/students/profile/import/linkedin', [
                'pdf' => UploadedFile::fake()->create('linkedin.pdf'),
            ]);

            $response->assertRedirect('/students/profile');

            $profile->refresh();

            $this->assertSame('', $profile->first_name);
            $this->assertSame('', $profile->last_name);
            $this->assertNull($profile->summary);
            $this->assertSame('', $profile->phone_number);
            $this->assertSame([], $profile->skills->pluck('name')->toArray());

            $this->assertCount(1, $profile->academicRecords);
            $record = $profile->academicRecords->first();
            $this->assertSame('', $record->degree);
            $this->assertSame('', $record->institution);
            $this->assertSame(now()->toDateString(), $record->start->toDateString());
            $this->assertSame(now()->toDateString(), $record->end->toDateString());
            $this->assertSame('', $record->description);

            $this->assertCount(1, $profile->professionalExperiences);
            $experience = $profile->professionalExperiences->first();
            $this->assertSame('', $experience->title);
            $this->assertSame('', $experience->contract_type);
            $this->assertSame('', $experience->company_name);
            $this->assertSame('', $experience->location);
            $this->assertSame(now()->toDateString(), $experience->start->toDateString());
            $this->assertSame(now()->toDateString(), $experience->end->toDateString());
            $this->assertSame('', $experience->description);
        });
    }

    public function test_will_create_profile(): void
    {
        $this->createFilledPdfMock();

        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->post('/students/profile/import/linkedin', [
            'pdf' => UploadedFile::fake()->create('linkedin.pdf'),
        ]);

        $response->assertRedirect('/students/profile');

        $this->assertNotNull($student->studentProfile()->first());
    }
}
