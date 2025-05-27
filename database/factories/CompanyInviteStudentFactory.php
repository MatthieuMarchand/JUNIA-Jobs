<?php

namespace Database\Factories;

use App\Models\CompanyInviteStudent;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyInviteStudent>
 */
class CompanyInviteStudentFactory extends Factory
{
    protected $model = CompanyInviteStudent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_profile_id' => CompanyProfile::factory(),
            'student_profile_id' => StudentProfile::factory(),
            'sent' => now(),
            'invitation_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'invitation_details' => $this->faker->paragraph,
            'invitation_status' => $this->faker->randomElement([
                'sent',
                'read',
                'accepted',
                'declined',
                'interview_scheduled',
                'completed',
            ]),
        ];
    }
}
