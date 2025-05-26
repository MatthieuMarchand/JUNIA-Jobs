<?php

namespace Tests\Feature\Student\Profile;

use App\Models\ProfessionalExperience;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

class ProfessionalExperiencesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_experience(): void
    {
        $profile = StudentProfile::factory()->create();

        $start = now()->subYear()->toDateString();
        $end = now()->toDateString();
        $response = $this->actingAs($profile->user)->post('/students/profile/professional-experiences', [
            "title" => "Software Engineer",
            "contract_type" => "Full-time",
            "company_name" => "Tech Company",
            "location" => "New York",
            "start" => $start,
            "end" => $end,
            "description" => "Worked on various projects.",
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();

        $experience = $profile->professionalExperiences()->first();
        $this->assertSame("Software Engineer", $experience->title);
        $this->assertSame("Full-time", $experience->contract_type);
        $this->assertSame("Tech Company", $experience->company_name);
        $this->assertSame("New York", $experience->location);
        $this->assertSame($start, $experience->start->toDateString());
        $this->assertSame($end, $experience->end->toDateString());
        $this->assertSame("Worked on various projects.", $experience->description);
    }

    public function test_can_update_experience(): void
    {
        $profile = StudentProfile::factory()->create();
        $experience = ProfessionalExperience::factory()->for($profile)->create();

        $start = now()->subYear()->toDateString();
        $end = now()->toDateString();
        $response = $this->actingAs($profile->user)->patch("/students/profile/professional-experiences/$experience->id", [
            "title" => "Software Engineer",
            "contract_type" => "Full-time",
            "company_name" => "Tech Company",
            "location" => "New York",
            "start" => $start,
            "end" => $end,
            "description" => "Worked on various projects.",
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();

        $experience = $profile->professionalExperiences()->first();
        $this->assertSame("Software Engineer", $experience->title);
        $this->assertSame("Full-time", $experience->contract_type);
        $this->assertSame("Tech Company", $experience->company_name);
        $this->assertSame("New York", $experience->location);
        $this->assertSame($start, $experience->start->toDateString());
        $this->assertSame($end, $experience->end->toDateString());
        $this->assertSame("Worked on various projects.", $experience->description);
    }

    public function test_cannot_update_other_user_experience(): void
    {
        $otherUser = User::factory()->student()->create();
        $experience = ProfessionalExperience::factory()->create();

        $response = $this->actingAs($otherUser)->patch("/students/profile/professional-experiences/$experience->id");

        $response->assertForbidden();
        $this->assertEquals($experience->toArray(), $experience->fresh()->toArray());
    }

    public function test_can_delete_experience(): void
    {
        $experience = ProfessionalExperience::factory()->create();

        $response = $this->actingAs($experience->studentProfile->user)->delete("/students/profile/professional-experiences/$experience->id");

        $response->assertRedirect('/students/profile');
        $this->assertDatabaseMissing('professional_experiences', [
            'id' => $experience->id,
        ]);
    }

    public function test_cannot_delete_other_user_experience(): void
    {
        $otherUser = User::factory()->student()->create();
        $experience = ProfessionalExperience::factory()->create();

        $response = $this->actingAs($otherUser)->delete("/students/profile/professional-experiences/$experience->id");

        $response->assertForbidden();
        $this->assertDatabaseHas('professional_experiences', [
            'id' => $experience->id,
        ]);
    }
}
