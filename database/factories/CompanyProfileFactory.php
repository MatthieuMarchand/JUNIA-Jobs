<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use App\Models\User;
use Database\Factories\Traits\HasFakePhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    use HasFakePhoto;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->company(),
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
        ];
    }
}
