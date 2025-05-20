<?php

namespace Tests\Feature\Student\Profile;

use App\Models\Skill;
use App\Models\StudentProfile;
use Database\Seeders\ProductionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileSkillsTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_skills_if_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstSkill = Skill::first();
        $lastSkill = Skill::offset(1)->first();

        $profile->skills()->sync([$firstSkill->name]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'skill_names' => [$lastSkill->name],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$lastSkill->name], $profile->skills()->pluck('name')->toArray());
    }

    public function test_do_not_update_skills_if_not_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstSkill = Skill::first();
        $profile->skills()->sync([$firstSkill->name]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$firstSkill->name], $profile->skills()->pluck('name')->toArray());
    }

    public function test_create_skill_if_dont_exists(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'skill_names' => ['New Skill'],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame(['New Skill'], $profile->skills()->pluck('name')->toArray());
    }
}
