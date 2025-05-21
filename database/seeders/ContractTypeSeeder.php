<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
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

        foreach ($types as $type) {
            ContractType::create($type);
        }
    }
}
