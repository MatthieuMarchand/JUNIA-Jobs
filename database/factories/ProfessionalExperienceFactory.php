<?php

namespace Database\Factories;

use App\Models\ProfessionalExperience;
use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfessionalExperience>
 */
class ProfessionalExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeBetween('-5 years', 'now');
        $end_date = $this->faker->dateTimeBetween($start_date, 'now');

        return [
            'student_profile_id' => StudentProfile::factory(),
            'title' => $this->faker->jobTitle(),
            'contract_type' => $this->faker->randomElement(['CDI', 'CDD', 'Stage', 'Alternance']),
            'company_name' => $this->faker->company(),
            'location' => $this->faker->city(),
            'start' => $start_date,
            'end' => $end_date,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
