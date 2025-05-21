<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = [
            "Web",
            "Logiciel",
            "Électronique",
            "Réseau",
            "Système",
            "Sécurité",
            "Intelligence Artificielle",
            "Mobile",
            "Cloud",
            "Data",
        ];

        foreach ($domains as $domain) {
            Domain::create(["name" => $domain]);
        }
    }
}
