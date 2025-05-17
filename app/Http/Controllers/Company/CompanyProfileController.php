<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use function to_route;

class CompanyProfileController extends Controller
{
    public function show()
    {
        return view('students.profile');
    }

    private function getCompanyProfile(): CompanyProfile
    {
        // Si pas de companyProfile existant en bdd, on en instancie un à la volée (il n'est pas créé en bdd, seulement en php).
        // Comme ça la vue reçoit toujours un companyProfile non null
        return Auth::user()->companyProfile()->firstOrNew();
    }

    public function edit()
    {
        $companyProfile = $this->getCompanyProfile();

        Gate::authorize('update', $companyProfile);
        // TODO : créer la vue pour l'édition du profil de l'entreprise
    }

    public function update(Request $request): RedirectResponse
    {
        $companyProfile = $this->getCompanyProfile();

        Gate::authorize('update', $companyProfile);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
        ]);

        $companyProfile->name = $validated['name'];
        $companyProfile->description = $validated['description'];

        $companyProfile->save();

        return to_route('companies.profile.edit');
    }
}
