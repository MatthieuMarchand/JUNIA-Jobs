<?php

namespace Database\Factories;

use App\Models\AcademicRecord;
use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicRecord>
 */
class AcademicRecordFactory extends Factory
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
            'degree' => $this->faker->randomElement([
                'Licence',
                'Master',
                'Doctorat',
                'Diplôme d’ingénieur',
                'BTS',
                'DUT',
            ]),
            'institution' => $this->faker->company(),
            'start' => $start_date,
            'end' => $end_date,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
