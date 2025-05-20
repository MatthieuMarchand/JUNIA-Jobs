<?php

namespace Tests\Feature\Student\Profile;

use App\Models\StudentProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_without_photo_will_not_delete_the_current(): void
    {
        $profile = StudentProfile::factory()->withPhoto()->create();

        $photoPath = $profile->photo_path;

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
        ]);

        $response->assertRedirect();

        $profile->refresh();
        $this->assertSame($photoPath, $profile->photo_path);
        Storage::assertExists($photoPath);
    }

    public function test_update_with_photo_will_delete_the_current(): void
    {
        $profile = StudentProfile::factory()->withPhoto()->create();

        $photoPath = $profile->photo_path;

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'photo' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect();

        Storage::assertMissing($photoPath);
    }

    public function test_update_with_null_photo_will_delete_the_current(): void
    {
        $profile = StudentProfile::factory()->withPhoto()->create();

        $photoPath = $profile->photo_path;

        $response = $this->actingAs($profile->user)->patch('/students/profile', [
            ...$profile->toArray(),
            'photo' => null,
        ]);

        $response->assertRedirect();

        Storage::assertMissing($photoPath);
    }
}
