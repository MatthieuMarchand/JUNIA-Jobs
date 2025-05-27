<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyInviteStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CompanyInvitationHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        Gate::authorize('viewAny', CompanyInviteStudent::class);

        $companyUser = Auth::user();
        if (! $companyUser || ! $companyUser->companyProfile) {
            return redirect()
                ->route('companies.profile.show')
                ->with('error', 'Profil entreprise non configuré.');
        }

        $invitations = CompanyInviteStudent::where('company_profile_id', $companyUser->companyProfile->id)
            ->with('studentProfile')
            ->orderBy('sent', 'desc')
            ->paginate(10);

        return view('companies.invitation.index', compact('invitations'));
    }
}
