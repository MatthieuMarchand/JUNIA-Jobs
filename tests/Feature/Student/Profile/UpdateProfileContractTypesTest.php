<?php

namespace Tests\Feature\Student\Profile;

use App\Models\ContractType;
use App\Models\StudentProfile;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileContractTypesTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_contract_types_if_present(): void
    {
        $this->seed(DatabaseSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstContract = ContractType::first();
        $lastContract = ContractType::latest('id')->first();

        $profile->contractTypes()->sync([$firstContract->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'contract_preferences' => [
                [
                    'contract_type_id' => $lastContract->id,
                ],
            ],
        ]);

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$lastContract->id], $profile->contractTypes()->pluck('id')->toArray());
    }

    public function test_do_not_update_contract_types_if_not_present(): void
    {
        $this->seed(DatabaseSeeder::class);

        $profile = StudentProfile::factory()->create();

        $firstContract = ContractType::first();
        $profile->contractTypes()->sync([$firstContract->id]);

        $response = $this->actingAs($profile->user)->patch('/students/profile', $profile->toArray());

        $response->assertRedirect('/students/profile');

        $profile->refresh();
        $this->assertSame([$firstContract->id], $profile->contractTypes()->pluck('id')->toArray());
    }
}
