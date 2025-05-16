<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crée un compte administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Création d\'un compte administrateur');

        $email = $this->ask('Email');
        $password = $this->secret('Mot de passe');

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'gdpr_consent' => true,
            'role' => UserRole::Administrator,
        ]);

        $this->info('Compte administrateur créé avec succès !');
    }
}
