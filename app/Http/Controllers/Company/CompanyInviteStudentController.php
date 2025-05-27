<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyInviteStudent;
use App\Models\StudentProfile;
use App\Notifications\SendStudentInvitationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CompanyInviteStudentController extends Controller
{
    public function __invoke(StudentProfile $studentProfile, Request $request)
    {
        // Vérifier l'autorisation
        Gate::authorize('viewAny', StudentProfile::class);

        $companyUser = Auth::user();

        if (! $companyUser || ! $companyUser->companyProfile) {
            return redirect()
                ->back()
                ->with('error', 'Action non autorisée ou profil entreprise non configuré.');
        }

        $validated = $request->validate([
            'invitation_date' => 'required|date|after:today',
            'invitation_details' => 'required|string|min:10|max:1000',
        ]);

        $invitation = CompanyInviteStudent::create([
            'company_profile_id' => $companyUser->companyProfile->id,
            'student_profile_id' => $studentProfile->id,
            'sent' => Carbon::now(),
            'invitation_date' => $validated['invitation_date'],
            'invitation_details' => $validated['invitation_details'],
            'invitation_status' => 'sent',
        ]);

        if ($studentProfile->user) {
            $actionUrl = route('students.profile.show');

            $studentProfile->user->notify(new SendStudentInvitationNotification(
                $companyUser->companyProfile->name,
                $invitation->invitation_details,
                $actionUrl
            ));

            return redirect()
                ->route('companies.students')
                ->with('success', "Envoi de l'invitation effectuée ! Un email a été envoyé à l'étudiant");
        } else {
            return redirect()
                ->route('companies.students.show', $studentProfile->id)
                ->with('error', "Impossible d'envoyer l'invitation, l'utilisateur n'existe pas.");
        }
    }
}
