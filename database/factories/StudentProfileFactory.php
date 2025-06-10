<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use App\Models\User;
use Database\Factories\Traits\HasFakePhoto;
use Illuminate\Database\Eloquent\Factories\Factory;
use function fake;

/**
 * @extends Factory<StudentProfile>
 */
class StudentProfileFactory extends Factory
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
            'user_id' => User::factory()->student(),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'summary' => fake()->paragraph,
            'phone_number' => fake()->phoneNumber,
            'driver_license' => fake()->boolean(70),
            'vehicle' => fake()->boolean(50),
        ];
    }
}
