<?php

namespace Tests\Feature\Company;

use App\Models\CompanyRegistrationRequest;
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

    public function test_can_login_with_correct_credentials_when_approved(): void
    {
        $user = User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->approved())
            ->create([
                'password' => 'password',
            ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/companies/profile');

        $this->assertAuthenticatedAs($user);
    }

    public function test_cannot_login_when_unapproved(): void
    {
        $user = User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->unapproved())
            ->create([
                'password' => 'password',
            ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()
            ->company()
            ->has(CompanyRegistrationRequest::factory()->approved())
            ->create([
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
