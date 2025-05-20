<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(['name' => 'Automatisation']);
        Skill::create(['name' => 'Gestion de projet']);
        Skill::create(['name' => 'Développement logiciel']);
        Skill::create(['name' => 'Développement web']);
        Skill::create(['name' => 'Électronique']);
        Skill::create(['name' => 'Dimensionnement']);
        Skill::create(['name' => 'Facturation']);
        Skill::create(['name' => 'Autonomie']);
        Skill::create(['name' => 'Recherche']);
        Skill::create(['name' => 'Escalade']);
    }
}
