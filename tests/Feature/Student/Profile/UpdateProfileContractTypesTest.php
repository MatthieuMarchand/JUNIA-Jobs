<?php

namespace Tests\Feature\Student\Profile;

use App\Models\ContractType;
use App\Models\StudentProfile;
use Database\Seeders\ProductionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileContractTypesTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_contract_types_if_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstContract = ContractType::first();
        $lastContract = ContractType::latest('id')->first();

        $profile->contactTypes()->sync([$firstContract->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'contract_type_ids' => [$lastContract->id],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$lastContract->id], $profile->contactTypes()->pluck('id')->toArray());
    }

    public function test_do_not_update_contract_types_if_not_present(): void
    {
        $this->seed(ProductionSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstContract = ContractType::first();
        $profile->contactTypes()->sync([$firstContract->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', $profile->toArray());

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$firstContract->id], $profile->contactTypes()->pluck('id')->toArray());
    }
}
