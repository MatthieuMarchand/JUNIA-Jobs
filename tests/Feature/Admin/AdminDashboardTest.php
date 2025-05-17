<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_when_logged_as_admin(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
    }

    public function test_cannot_view_when_logged_as_student(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    }

    public function test_cannot_view_when_logged_as_company(): void
    {
        $user = User::factory()->company()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    }
}
