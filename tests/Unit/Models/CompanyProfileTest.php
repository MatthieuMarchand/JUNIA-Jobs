<?php

namespace Tests\Unit\Models;

use App\Models\CompanyProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function now;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_temporary_photo_url_expires_after_1_minute_for_privacy(): void
    {
        $profile = CompanyProfile::factory()->withPhoto()->create();

        $publicPhotoUrl = $profile->temporaryPhotoUrl();
        $this->assertNotNull($publicPhotoUrl);
        $pictureResponse = $this->get($publicPhotoUrl);
        $pictureResponse->assertOk();

        $this->travelTo(now()->addMinutes(2));
        $pictureResponse = $this->get($publicPhotoUrl);
        $pictureResponse->assertForbidden();
    }
}
