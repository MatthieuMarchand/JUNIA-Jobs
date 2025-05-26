<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRegistrationRequest;
use App\Notifications\ApprovedCompanyRegistrationNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;

class ApproveCompanyRegisterRequestController extends Controller
{
    public function __invoke(CompanyRegistrationRequest $registrationRequest)
    {
        Gate::authorize('update', $registrationRequest);

        if ($registrationRequest->approved) {
            return redirect()
                ->route('admin.companies.requests.index')
                ->with('error', 'Cette demande a déjà été approuvée.');
        }

        $registrationRequest->update([
            'approved' => true,
        ]);

        $token = Password::createToken($registrationRequest->user);
        $registrationRequest->user->notify(new ApprovedCompanyRegistrationNotification($token));

        return redirect()
            ->route('admin.companies.requests.index')
            ->with('success', "Demande approuvée ! Un email a été envoyé à l'entreprise pour qu'elle crée son mot de passe.");
    }
}
