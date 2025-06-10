<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentProfileHobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            'Football',
            'Basketball',
            'Tennis',
            'Natation',
            'Course à pied',
            'Cyclisme',
            'Escalade',
            'Randonnée',
            'Photographie',
            'Lecture',
            'Cuisine',
            'Jardinage',
            'Musique',
            'Guitare',
            'Piano',
            'Chant',
            'Dessin',
            'Peinture',
            'Cinéma',
            'Jeux vidéo',
            'Échecs',
            'Voyage',
            'Danse',
            'Théâtre',
            'Programmation',
        ];

        $studentProfiles = StudentProfile::all();

        foreach ($studentProfiles as $profile) {
            // Attribuer 2 à 5 hobbies aléatoires à chaque étudiant
            $randomHobbies = collect($hobbies)->random(fake()->numberBetween(2, 5));
            
            foreach ($randomHobbies as $hobby) {
                DB::table('student_profile_hobbies')->insert([
                    'student_profile_id' => $profile->id,
                    'hobby_name' => $hobby,
                ]);
            }
        }
    }
}
