<?php

namespace Tests\Feature\Admin;

use App\Models\CompanyRegistrationRequest;
use App\Models\User;
use App\Notifications\ApprovedCompanyRegistrationNotification;
use App\Utils\RouteGuesser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\TestCase;
use function resolve;

class RegistrationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_when_logged_as_admin(): void
    {
        $approved = CompanyRegistrationRequest::factory()->create([
            'company_name' => 'Approved Company',
            'approved' => true,
        ]);

        $unapproved = CompanyRegistrationRequest::factory()->create([
            'company_name' => 'Unapproved Company',
            'approved' => false,
        ]);

        $user = User::factory()->admin()->create();
        $response = $this->actingAs($user)->get('/admin/companies/requests');

        $response->assertStatus(200);
        $response->assertDontSee($approved->company_name);
        $response->assertSee($unapproved->company_name);
    }

    public function test_cannot_list_when_logged_as_student(): void
    {
        $user = User::factory()->student()->create();

        $response = $this->actingAs($user)->get('/admin/companies/requests');

        $response->assertForbidden();
    }

    public function test_cannot_list_when_logged_as_company(): void
    {
        $user = User::factory()->company()->create();

        $response = $this->actingAs($user)->get('/admin/companies/requests');

        $response->assertForbidden();
    }

    public function test_approve_will_send_mail_with_new_password(): void
    {
        Notification::fake();

        $user = User::factory()->admin()->create();

        $registrationRequest = CompanyRegistrationRequest::factory()->create();

        $response = $this->actingAs($user)->post("/admin/companies/requests/{$registrationRequest->id}/approve");

        $response->assertRedirect('/admin/companies/requests');
        $response->assertSessionHas('success', "Demande approuvée ! Un email a été envoyé à l'entreprise pour qu'elle crée son mot de passe.");

        $registrationRequest->refresh();

        $routeGuesser = resolve(RouteGuesser::class);

        Notification::assertSentTo($registrationRequest->user, ApprovedCompanyRegistrationNotification::class,
            function (ApprovedCompanyRegistrationNotification $notification) use ($registrationRequest, $routeGuesser) {
                $actionUrl = $notification->toMail($registrationRequest->user)->actionUrl;

                return $routeGuesser->fromUrl($actionUrl)->getName() === 'password-reset.create';
            });

        $this->assertTrue($registrationRequest->approved);
    }

    public function test_cannot_approve_when_logged_as_company(): void
    {
        $user = User::factory()->company()->create();

        $registrationRequest = CompanyRegistrationRequest::factory()->create();

        $response = $this->actingAs($user)->post("/admin/companies/requests/{$registrationRequest->id}/approve");

        $response->assertForbidden();
    }

    public function test_cannot_approve_when_logged_as_student(): void
    {
        $user = User::factory()->student()->create();

        $registrationRequest = CompanyRegistrationRequest::factory()->create();

        $response = $this->actingAs($user)->post("/admin/companies/requests/{$registrationRequest->id}/approve");

        $response->assertForbidden();
    }

    public function test_cannot_approve_already_approved_request(): void
    {
        $user = User::factory()->admin()->create();

        $registrationRequest = CompanyRegistrationRequest::factory()->approved()->create();

        $response = $this->actingAs($user)->post("/admin/companies/requests/{$registrationRequest->id}/approve");

        $response->assertRedirect('/admin/companies/requests');
        $response->assertSessionHas('error', 'Cette demande a déjà été approuvée.');
    }
}
