<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CompanyInviteStudent;
use Illuminate\Support\Facades\Gate;

class StudentDeclineInvitationController extends Controller
{
    public function __invoke(CompanyInviteStudent $invitation)
    {
        Gate::authorize('viewStudent', $invitation);

        $invitation->update([
            'invitation_status' => 'declined',
        ]);

        return redirect()
            ->route('students.invitations.history')
            ->with('success', "Invitation refusée. L'entreprise a été notifiée.");
    }
}
