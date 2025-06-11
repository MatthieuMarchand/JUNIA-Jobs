<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Données nécessaires à la production
     */
    public function run(): void
    {
        $this->call(ContractTypeSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(DomainSeeder::class);
    }
}
