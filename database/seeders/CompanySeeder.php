<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\CompanyRegistrationRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function pathinfo;
use const PATHINFO_FILENAME;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logosPaths = Storage::disk('seed')->allFiles("logos");

        foreach ($logosPaths as $index => $logoPath) {
            $basename = basename($logoPath);
            $companyName = Str::headline(pathinfo($logoPath, PATHINFO_FILENAME));

            $targetPath = "photos/" . $basename;
            Storage::put($targetPath, Storage::disk('seed')->get("logos/" . $basename));

            User::factory()->company()
                ->has(
                    CompanyProfile::factory()->state([
                        'name' => $companyName,
                        'photo_path' => $targetPath,
                    ])
                )
                ->create([
                    'email' => Str::slug($companyName) . '@example.com',
                ]);
        }

        User::factory()
            ->company()
            ->has(CompanyProfile::factory())
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
    }
}
