<?php

namespace Tests\Feature\Company\Profile;

use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/companies/profile/edit');

        $response->assertStatus(200);
    }

    public function test_can_update(): void
    {
        $user = User::factory()->create();
        $profile = $user->companyProfile()->create([
            'name' => 'Ariane',
            'description' => '',
        ]);

        $response = $this->actingAs($user)->patch('/companies/profile', [
            'name' => 'Airbus',
            'description' => 'Lorem',
        ]);

        $response->assertRedirect('/companies/profile');
        $response->assertSessionHas('success', 'Profil mis à jour !');

        $profile->refresh();
        $this->assertSame('Airbus', $profile->name);
        $this->assertSame('Lorem', $profile->description);
    }

    public function test_update_will_create_profile_if_none(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount(CompanyProfile::class, 0);

        $response = $this->actingAs($user)->patch('/companies/profile', [
            'name' => 'Airbus',
            'description' => 'Lorem',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount(CompanyProfile::class, 1);
    }
}
