<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CompanyInviteStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentInvitationHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        Gate::authorize('viewAsStudent', CompanyInviteStudent::class);

        $studentUser = Auth::user();
        if (! $studentUser || ! $studentUser->studentProfile) {
            return redirect()
                ->route('students.profile.edit')
                ->with('error', 'Profil étudiant non configuré.');
        }

        $invitations = CompanyInviteStudent::where('student_profile_id', $studentUser->studentProfile->id)
            ->with('companyProfile')
            ->orderBy('sent', 'desc')
            ->paginate(10);

        return view('students.invitation.index', compact('invitations'));
    }
}
