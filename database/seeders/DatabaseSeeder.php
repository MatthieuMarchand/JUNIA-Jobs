<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\CompanyRegistrationRequest;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        User::factory()
            ->student()
            ->has(StudentProfile::factory())
            ->create([
                'email' => 'student@example.com',
                'password' => 'password',
            ]);

        User::factory()
            ->student()
            ->has(StudentProfile::factory())
            ->count(10)
            ->create([
                'password' => 'password',
            ]);

        User::factory()
            ->company()
            ->has(CompanyProfile::factory())
            ->has(CompanyRegistrationRequest::factory()->approved())
            ->create([
                'email' => 'company@example.com',
                'password' => 'password',
            ]);

        User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->unapproved())
            ->create([
                'email' => 'unapprovedcompany@example.com',
                'password' => 'password',
            ]);
    }
}
