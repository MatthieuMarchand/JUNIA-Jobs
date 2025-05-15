<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/students/profile');

        $this->assertAuthenticatedAs($user);
    }

    public function test_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'anotherpwd',
        ]);

        $response->assertSessionHasErrors(['password']);

        $this->assertGuest();
    }
}
