<?php

namespace Tests\Feature\Student\Profile;

use App\Models\ResearchArea;
use App\Models\StudentProfile;
use Database\Seeders\ProductionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileResearchAreasTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_areas_if_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstArea = ResearchArea::first();
        $lastArea = ResearchArea::latest('id')->first();

        $profile->researchAreas()->sync([$firstArea->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'research_area_ids' => [$lastArea->id],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$lastArea->id], $profile->researchAreas()->pluck('id')->toArray());
    }

    public function test_do_not_update_areas_if_not_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstArea = ResearchArea::first();
        $profile->researchAreas()->sync([$firstArea->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', $profile->toArray());

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$firstArea->id], $profile->researchAreas()->pluck('id')->toArray());
    }
}
