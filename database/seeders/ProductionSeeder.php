<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Rempli la BDD avec les données de base pour la production
     **/
    public function run(): void
    {
        $this->call(ContractTypeSeeder::class);
        $this->call(SkillSeeder::class);
    }
}
