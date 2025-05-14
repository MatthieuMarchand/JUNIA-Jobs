<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use function fake;

/**
 * @extends Factory<StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'summary' => fake()->paragraph,
            'phone_number' => fake()->phoneNumber,
        ];
    }

    public function withPhoto(): static
    {
        return $this->state(function (array $attributes) {
            $photo = UploadedFile::fake()->image('profile.jpg');
            $path = $photo->store('photos');

            return [
                'photo_path' => $path,
            ];
        });
    }
}
