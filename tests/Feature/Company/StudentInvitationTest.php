<?php

namespace Tests\Feature\Company;

use App\Models\CompanyInviteStudent;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use App\Notifications\SendStudentInvitationNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class StudentInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_invitation_to_student(): void
    {
        Notification::fake();

        $studentProfile = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        $future = Carbon::now()->addDays(5)->format('Y-m-d');

        $response = $this->actingAs($companyProfile->user)->post("/companies/students/{$studentProfile->id}/invite", [
            'invitation_date' => $future,
            'invitation_details' => 'Nous aimerions vous rencontrer pour discuter d\'une opportunité de stage.',
        ]);

        $response->assertRedirect('/companies/students');
        $response->assertSessionHas('success', "Envoi de l'invitation effectuée ! Un email a été envoyé à l'étudiant");

        // Vérification de la notification
        Notification::assertSentTo(
            $studentProfile->user,
            SendStudentInvitationNotification::class,
            function ($notification, $channels) use ($companyProfile) {
                return $notification->companyName === $companyProfile->name
                    && $notification->invitationDetails !== null
                    && in_array('mail', $channels);
            }
        );

        // Vérification en base de données
        $this->assertDatabaseHas('interview_invitations', [
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'invitation_status' => 'sent',
        ]);
    }

    public function test_company_can_view_invitations_history(): void
    {
        $companyProfile = CompanyProfile::factory()->create();
        $studentProfile = StudentProfile::factory()->create();

        // Créer quelques invitations
        CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Détails de l\'invitation',
            'invitation_status' => 'sent',
        ]);

        $response = $this->actingAs($companyProfile->user)
            ->get('/companies/invitations');

        $response->assertStatus(200);
        $response->assertViewIs('companies.invitation.index');
        $response->assertViewHas('invitations');
        $response->assertSee('Détails de l\'invitation');
    }

    public function test_student_can_view_invitations(): void
    {
        $studentProfile = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        // Créer une invitation
        CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Détails de l\'invitation',
            'invitation_status' => 'sent',
        ]);

        $response = $this->actingAs($studentProfile->user)
            ->get('/students/invitations/history');

        $response->assertStatus(200);
        $response->assertViewIs('students.invitation.index');
        $response->assertSee('Détails de l\'invitation');
        $response->assertSee($companyProfile->name);
    }

    public function test_student_can_accept_invitation(): void
    {
        $studentProfile = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        $invitation = CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Détails de l\'invitation',
            'invitation_status' => 'sent',
        ]);

        $response = $this->actingAs($studentProfile->user)
            ->post("/students/invitations/{$invitation->id}/accept");

        $response->assertRedirect('/students/invitations/history');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('interview_invitations', [
            'id' => $invitation->id,
            'invitation_status' => 'accepted',
        ]);
    }

    public function test_student_can_decline_invitation(): void
    {
        $studentProfile = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        $invitation = CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Détails de l\'invitation',
            'invitation_status' => 'sent',
        ]);

        $response = $this->actingAs($studentProfile->user)
            ->post("/students/invitations/{$invitation->id}/decline");

        $response->assertRedirect('/students/invitations/history');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('interview_invitations', [
            'id' => $invitation->id,
            'invitation_status' => 'declined',
        ]);
    }

    public function test_cannot_send_invitation_with_invalid_date(): void
    {
        $studentProfile = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        $pastDate = Carbon::yesterday()->format('Y-m-d');

        $response = $this->actingAs($companyProfile->user)
            ->post("/companies/students/{$studentProfile->id}/invite", [
                'invitation_date' => $pastDate,
                'invitation_details' => 'Détails de l\'invitation',
            ]);

        $response->assertSessionHasErrors(['invitation_date']);
    }

    public function test_unauthorized_user_cannot_view_other_company_invitations(): void
    {
        $companyProfile1 = CompanyProfile::factory()->create();
        $companyProfile2 = CompanyProfile::factory()->create();
        $studentProfile = StudentProfile::factory()->create();

        // Créer une invitation pour company1
        $invitation = CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile1->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Détails de l\'invitation',
            'invitation_status' => 'sent',
        ]);

        // Company2 ne devrait pas voir les invitations de company1
        $this->actingAs($companyProfile2->user)
            ->get('/companies/invitations')
            ->assertDontSee('Détails de l\'invitation');
    }

    public function test_unauthorized_user_cannot_view_other_student_invitations(): void
    {
        $studentProfile1 = StudentProfile::factory()->create();
        $studentProfile2 = StudentProfile::factory()->create();
        $companyProfile = CompanyProfile::factory()->create();

        // Créer une invitation pour student1
        CompanyInviteStudent::create([
            'company_profile_id' => $companyProfile->id,
            'student_profile_id' => $studentProfile1->id,
            'sent' => Carbon::now(),
            'invitation_date' => Carbon::now()->addDays(5),
            'invitation_details' => 'Invitation pour étudiant 1',
            'invitation_status' => 'sent',
        ]);

        // Student2 ne devrait pas voir les invitations de student1
        $response = $this->actingAs($studentProfile2->user)
            ->get('/students/invitations');

        $response->assertDontSee('Invitation pour étudiant 1');
    }
}
