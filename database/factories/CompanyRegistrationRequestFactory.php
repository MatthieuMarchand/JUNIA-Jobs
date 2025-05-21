<?php

namespace Database\Factories;

use App\Models\CompanyRegistrationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyRegistrationRequest>
 */
class CompanyRegistrationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->company(),
            'company_name' => $this->faker->company(),
            'message' => $this->faker->sentence(),
            'approved' => false,
        ];
    }

    public function unapproved(): static
    {
        return $this->state(fn(array $attributes) => [
            'approved' => false,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'approved' => true,
        ]);
    }
}
