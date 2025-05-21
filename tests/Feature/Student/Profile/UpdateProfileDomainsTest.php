<?php

namespace Tests\Feature\Student\Profile;

use App\Models\Domain;
use App\Models\StudentProfile;
use Database\Seeders\ProductionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileDomainsTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_domains_if_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstDomain = Domain::first();
        $lastDomain = Domain::offset(1)->first();

        $profile->domains()->sync([$firstDomain->name]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'domain_names' => [$lastDomain->name],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$lastDomain->name], $profile->domains()->pluck('name')->toArray());
    }

    public function test_do_not_update_domains_if_not_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstDomain = Domain::first();
        $profile->domains()->sync([$firstDomain->name]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$firstDomain->name], $profile->domains()->pluck('name')->toArray());
    }

    public function test_create_domain_if_dont_exists(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'domain_names' => ['New Domain'],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame(['New Domain'], $profile->domains()->pluck('name')->toArray());
    }
}
