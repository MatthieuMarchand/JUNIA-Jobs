<?php

namespace Tests\Feature\Student\Profile;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/students/profile/edit');

        $response->assertStatus(200);
    }

    public function test_can_update(): void
    {
        $user = User::factory()->create();
        $profile = $user->studentProfile()->create([
            'first_name' => 'Jane',
            'last_name' => 'Dane',
            'summary' => '',
            'phone_number' => '0987654321',
        ]);

        $response = $this->actingAs($user)->patch('/students/profile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'summary' => 'Lorem ipsum dolor sit amet.',
            'phone_number' => '1234567890',
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect('/students/profile');
        $response->assertSessionHas('success', 'Profil mis à jour !');

        $profile->refresh();
        $this->assertSame('John', $profile->first_name);
        $this->assertSame('Doe', $profile->last_name);
        $this->assertSame('Lorem ipsum dolor sit amet.', $profile->summary);
        $this->assertSame('1234567890', $profile->phone_number);

        $publicPhotoUrl = $profile->temporaryPhotoUrl();
        $this->assertNotNull($publicPhotoUrl);
        $pictureResponse = $this->get($publicPhotoUrl);
        $pictureResponse->assertOk();
    }

    public function test_update_will_create_profile_if_none(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount(StudentProfile::class, 0);

        $response = $this->actingAs($user)->patch('/students/profile', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'summary' => 'Lorem ipsum dolor sit amet.',
            'phone_number' => '1234567890',
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect('/students/profile');

        $this->assertDatabaseCount(StudentProfile::class, 1);
    }
}
