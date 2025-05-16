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

    public function test_create_company_request(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'company_name' => 'Example',
            'message' => 'Hello, world!',
            'gdpr_consent' => 'true',
        ]);

        $response->assertOk();

        $this->assertGuest();

        $user = User::first();

        $this->assertSame('text@example.com', $user->email);
        $this->assertNotNull($user->password);
        $this->assertSame(UserRole::Company, $user->role);
        $this->assertTrue($user->gdpr_consent);

        $this->assertSame("Example", $user->companyRegistrationRequest->company_name);
        $this->assertSame('Hello, world!', $user->companyRegistrationRequest->message);
        $this->assertFalse($user->companyRegistrationRequest->approved);
    }

    public function test_cannot_register_without_email(): void
    {
        $response = $this->post('/companies/register', [
            'company_name' => 'Example',
            'message' => 'Hello, world!',
            'gdpr_consent' => 'true',
        ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseCount(User::class, 0);
    }

    public function test_cannot_register_without_company_name(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'message' => 'Hello, world!',
            'gdpr_consent' => 'true',
        ]);

        $response->assertSessionHasErrors(['company_name']);

        $this->assertDatabaseCount(User::class, 0);
    }

    public function test_cannot_register_without_consenting_gdpr(): void
    {
        $response = $this->post('/companies/register', [
            'email' => 'text@example.com',
            'company_name' => 'Example',
            'message' => 'Hello, world!',
        ]);

        $response->assertSessionHasErrors(['gdpr_consent']);

        $this->assertDatabaseCount(User::class, 0);
    }
}
