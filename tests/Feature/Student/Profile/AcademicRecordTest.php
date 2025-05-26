<?php

namespace Tests\Feature\Student\Profile;

use App\Models\AcademicRecord;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

class AcademicRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_record(): void
    {
        $profile = StudentProfile::factory()->create();

        $start = now()->subYear()->toDateString();
        $end = now()->toDateString();
        $response = $this->actingAs($profile->user)->post('/students/profile/academic-records', [
            "degree" => "Diplôme d'ingénieur",
            "institution" => "JUNIA ISEN Bordeaux",
            "start" => $start,
            "end" => $end,
            "description" => "Électronique, maths, informatique, gestion de projet.",
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();

        $record = $profile->academicRecords()->first();
        $this->assertSame("Diplôme d'ingénieur", $record->degree);
        $this->assertSame("JUNIA ISEN Bordeaux", $record->institution);
        $this->assertSame($start, $record->start->toDateString());
        $this->assertSame($end, $record->end->toDateString());
        $this->assertSame("Électronique, maths, informatique, gestion de projet.", $record->description);
    }

    public function test_can_update_record(): void
    {
        $profile = StudentProfile::factory()->create();
        $record = AcademicRecord::factory()->for($profile)->create();

        $start = now()->subYear()->toDateString();
        $end = now()->toDateString();
        $response = $this->actingAs($profile->user)->patch("/students/profile/academic-records/$record->id", [
            "degree" => "Diplôme d'ingénieur",
            "institution" => "JUNIA ISEN Bordeaux",
            "start" => $start,
            "end" => $end,
            "description" => "Électronique, maths, informatique, gestion de projet.",
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();

        $record->refresh();
        $this->assertSame("Diplôme d'ingénieur", $record->degree);
        $this->assertSame("JUNIA ISEN Bordeaux", $record->institution);
        $this->assertSame($start, $record->start->toDateString());
        $this->assertSame($end, $record->end->toDateString());
        $this->assertSame("Électronique, maths, informatique, gestion de projet.", $record->description);
    }

    public function test_cannot_update_other_user_experience(): void
    {
        $otherUser = User::factory()->student()->create();
        $record = AcademicRecord::factory()->create();

        $response = $this->actingAs($otherUser)->patch("/students/profile/academic-records/$record->id");

        $response->assertForbidden();
        $this->assertEquals($record->toArray(), $record->fresh()->toArray());
    }

    public function test_can_delete_experience(): void
    {
        $record = AcademicRecord::factory()->create();

        $response = $this->actingAs($record->studentProfile->user)->delete("/students/profile/academic-records/$record->id");

        $response->assertRedirect('/students/profile');
        $this->assertDatabaseMissing('academic_records', [
            'id' => $record->id,
        ]);
    }

    public function test_cannot_delete_other_user_experience(): void
    {
        $otherUser = User::factory()->student()->create();
        $record = AcademicRecord::factory()->create();

        $response = $this->actingAs($otherUser)->delete("/students/profile/academic-records/$record->id");

        $response->assertForbidden();
        $this->assertDatabaseHas('academic_records', [
            'id' => $record->id,
        ]);
    }
}
