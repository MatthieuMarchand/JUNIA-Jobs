<?php

namespace Database\Seeders;

use App\Models\ResearchArea;
use Illuminate\Database\Seeder;

class ResearchAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                "name" => "Apprenti ingénieur",
                "description" => "Contrat d’apprentissage dans le cadre d’une formation d’ingénieur",
            ],
            [
                "name" => "Professionnalisation 5ème année",
                "description" => "Contrat de professionnalisation en 5e année",
            ],
            [
                "name" => "Mobilité internationale",
                "description" => "Stage, cdd, apprentissage ou bénévolat à l'international",
            ],
            [
                "name" => "CDI",
                "description" => null,
            ],
            [
                "name" => "Stage technicien",
                "description" => "Stage de première ou deuxième année",
            ],
        ];

        foreach ($areas as $area) {
            ResearchArea::create($area);
        }
    }
}
