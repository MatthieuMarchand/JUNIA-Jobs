<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use function to_route;

class CompanyProfileController extends Controller
{
    public function show()
    {
        $companyProfile = $this->getCompanyProfile();

        Gate::authorize('view', $companyProfile);

        return view('companies.profile.show', [
            'companyProfile' => $companyProfile,
        ]);
    }

    private function getCompanyProfile(): CompanyProfile
    {
        // Si pas de companyProfile existant en bdd, on en instancie un à la volée (il n'est pas créé en bdd, seulement en php).
        // Comme ça la vue reçoit toujours un companyProfile non null
        $user = Auth::user();

        $profile = $user->companyProfile()->first();
        if ($profile) {
            return $profile;
        }

        return new CompanyProfile([
            'user_id' => $user->id,
            'name' => $user->companyRegistrationRequest?->name,
            'description' => '',
            'photo_path' => null,
        ]);
    }

    public function edit()
    {
        $companyProfile = $this->getCompanyProfile();

        Gate::authorize('update', $companyProfile);

        return view('companies.profile.edit', [
            'companyProfile' => $companyProfile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $companyProfile = $this->getCompanyProfile();

        Gate::authorize('update', $companyProfile);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:2000',
        ]);

        $companyProfile->name = $validated['name'];
        $companyProfile->description = $validated['description'];

        if ($companyProfile->photo_path && $request->has('photo')) {
            Storage::delete($companyProfile->photo_path);
            $companyProfile->photo_path = null;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos');
            $companyProfile->photo_path = $path;
        }

        $companyProfile->save();

        return to_route('companies.profile.show');
    }
}
