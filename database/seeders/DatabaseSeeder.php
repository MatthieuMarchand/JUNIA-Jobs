<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\CompanyRegistrationRequest;
use App\Models\ProfessionalExperience;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use function fake;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // "password" est le mot de passe de tous les utilisateurs générés
        // (voir UserFactory)

        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        User::factory()
            ->student()
            ->has(
                StudentProfile::factory()->has(
                    ProfessionalExperience::factory()->count(fake()->numberBetween(1, 3))
                )
            )
            ->create([
                'email' => 'student@example.com',
            ]);

        User::factory()
            ->student()
            ->has(
                StudentProfile::factory()->has(
                    ProfessionalExperience::factory()->count(fake()->numberBetween(1, 3))
                )
            )
            ->count(10)
            ->create();

        User::factory()
            ->company()
            ->has(CompanyProfile::factory())
            ->has(CompanyRegistrationRequest::factory()->approved())
            ->create([
                'email' => 'company@example.com',
            ]);

        User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->unapproved())
            ->create([
                'email' => 'unapprovedcompany@example.com',
            ]);

        User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->unapproved())
            ->count(10)
            ->create();

        $this->call(ProductionSeeder::class);
    }
}
