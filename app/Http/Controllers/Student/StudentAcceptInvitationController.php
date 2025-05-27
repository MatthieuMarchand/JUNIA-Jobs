<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CompanyInviteStudent;
use Illuminate\Support\Facades\Gate;

class StudentAcceptInvitationController extends Controller
{
    public function __invoke(CompanyInviteStudent $invitation)
    {
        Gate::authorize('viewStudent', $invitation);

        $invitation->update([
            'invitation_status' => 'accepted',
        ]);

        return redirect()
            ->route('students.invitations.history')
            ->with('success', "Invitation acceptée ! L'entreprise a été notifiée.");
    }
}
