<?php

namespace Tests\Feature\Company;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_display_form(): void
    {
        $response = $this->get('/companies/register');

        $response->assertStatus(200);
    }

    public function test_register_as_company(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gdpr_consent' => true,
        ]);

        $response->assertRedirect('/companies/profile');

        $user = User::first();
        $this->assertAuthenticatedAs($user);
        $this->assertSame(UserRole::Company, $user->role);
    }

    public function test_cannot_register_without_email(): void
    {
        $response = $this->post('/companies/register', [
            'password' => 'password',
            'password_confirmation' => 'password',
            'gdpr_consent' => true,
        ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseCount(User::class, 0);
        $this->assertGuest();
    }

    public function test_cannot_register_with_unmatching_passwords(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'password' => 'password',
            'password_confirmation' => 'password2',
            'gdpr_consent' => true,
        ]);

        $response->assertSessionHasErrors(['password']);

        $this->assertDatabaseCount(User::class, 0);
        $this->assertGuest();
    }

    public function test_cannot_register_without_consenting_gdpr(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['gdpr_consent']);

        $this->assertDatabaseCount(User::class, 0);
        $this->assertGuest();
    }
}
