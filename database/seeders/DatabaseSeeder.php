<?php

namespace Database\Seeders;

use App\Models\AcademicRecord;
use App\Models\CompanyProfile;
use App\Models\CompanyRegistrationRequest;
use App\Models\ContractType;
use App\Models\Domain;
use App\Models\ProfessionalExperience;
use App\Models\Skill;
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
        $this->call(ProductionSeeder::class);

        // "password" est le mot de passe de tous les utilisateurs générés
        // (voir UserFactory)

        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $student = User::factory()
            ->student()
            ->has(
                StudentProfile::factory()
                    ->withPhoto()
                    ->has(
                        ProfessionalExperience::factory()->count(fake()->numberBetween(1, 3))
                    )
                    ->has(
                        AcademicRecord::factory()->count(fake()->numberBetween(1, 3))
                    )
            )
            ->create([
                'email' => 'student@example.com',
            ]);

        $studentProfile = $student->studentProfile;
        $this->assignRelationsToStudentProfile($studentProfile);

        User::factory()
            ->student()
            ->has(
                StudentProfile::factory()
                    ->withPhoto()
                    ->has(
                        ProfessionalExperience::factory()->count(fake()->numberBetween(1, 3))
                    )
                    ->has(
                        AcademicRecord::factory()->count(fake()->numberBetween(1, 3))
                    )
            )
            ->count(10)
            ->create()
            ->each(function ($user) {
                $this->assignRelationsToStudentProfile($user->studentProfile);
            });

        User::factory()
            ->company()
            ->has(CompanyProfile::factory()->withPhoto())
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

        User::factory()
            ->company()
            ->has(CompanyProfile::factory()->withPhoto())
            ->has(CompanyRegistrationRequest::factory()->approved())
            ->count(5)
            ->create();

        // Ajout des hobbies et certifications pour les étudiants
        $this->call([
            StudentProfileHobbySeeder::class,
            CertificationSeeder::class,
        ]);

        // Ajout des invitations entre entreprises et étudiants
        $this->call(CompanyInviteStudentSeeder::class);
    }

    /**
     * Attribuer des domaines, compétences et types de contrat à un étudiant
     */
    private function assignRelationsToStudentProfile(StudentProfile $profile): void
    {
        // 2 à 4 domaines aléatoire
        $domains = Domain::inRandomOrder()->take(fake()->numberBetween(2, 4))->get();
        $profile->domains()->sync($domains->pluck('name')->toArray());

        // 3 à 6 compétences aléatoire
        $skills = Skill::inRandomOrder()->take(fake()->numberBetween(3, 6))->get();
        $profile->skills()->sync($skills->pluck('name')->toArray());

        // 1 à 3 types de contrats avec durée et rythme
        $contractTypes = ContractType::inRandomOrder()->take(fake()->numberBetween(1, 3))->get();
        $syncData = [];
        
        foreach ($contractTypes as $contractType) {
            $syncData[$contractType->id] = [
                'contract_duration' => fake()->randomElement(['6 mois', '1 an', '2 ans', '3 ans', 'Indéterminée']),
                'work_study_rhythm' => fake()->randomElement(['2 jours école / 3 jours entreprise', '1 semaine école / 1 semaine entreprise', '2 semaines école / 2 semaines entreprise', 'Temps plein'])
            ];
        }
        
        $profile->contractTypes()->sync($syncData);

        // Mettre à jour les champs driver_license et vehicle
        $profile->update([
            'driver_license' => fake()->boolean(70), // 70% de chance d'avoir le permis
            'vehicle' => fake()->boolean(50), // 50% de chance d'avoir un véhicule
        ]);
    }
}
