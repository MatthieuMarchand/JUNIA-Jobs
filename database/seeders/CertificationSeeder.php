<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            [
                'title' => 'AWS Certified Solutions Architect',
                'description' => 'Certification Amazon Web Services pour l\'architecture de solutions cloud'
            ],
            [
                'title' => 'Google Cloud Professional',
                'description' => 'Certification Google Cloud Platform pour les professionnels du cloud'
            ],
            [
                'title' => 'Microsoft Azure Fundamentals',
                'description' => 'Certification de base Microsoft Azure'
            ],
            [
                'title' => 'Cisco CCNA',
                'description' => 'Certification Cisco Certified Network Associate'
            ],
            [
                'title' => 'CompTIA Security+',
                'description' => 'Certification de sécurité informatique CompTIA'
            ],
            [
                'title' => 'Scrum Master Certified',
                'description' => 'Certification Scrum Master pour la gestion de projet agile'
            ],
            [
                'title' => 'Oracle Java SE Programmer',
                'description' => 'Certification Oracle pour la programmation Java'
            ],
            [
                'title' => 'Linux Professional Institute',
                'description' => 'Certification LPI pour l\'administration Linux'
            ],
            [
                'title' => 'Docker Certified Associate',
                'description' => 'Certification Docker pour la containerisation'
            ],
            [
                'title' => 'Kubernetes Administrator',
                'description' => 'Certification pour l\'administration Kubernetes'
            ],
        ];

        $studentProfiles = StudentProfile::all();

        foreach ($studentProfiles as $profile) {
            // 30% de chance d'avoir des certifications
            if (fake()->boolean(30)) {
                // 1 à 3 certifications par étudiant qui en a
                $numberOfCertifications = fake()->numberBetween(1, 3);
                $randomCertifications = collect($certifications)->random($numberOfCertifications);
                
                foreach ($randomCertifications as $cert) {
                    DB::table('certifications')->insert([
                        'student_profile_id' => $profile->id,
                        'title' => $cert['title'],
                        'date_obtained' => Carbon::now()->subDays(fake()->numberBetween(30, 1095)), // Entre 1 mois et 3 ans
                        'description' => $cert['description'],
                        'link' => fake()->boolean(60) ? fake()->url() : null, // 60% de chance d'avoir un lien
                    ]);
                }
            }
        }
    }
}
