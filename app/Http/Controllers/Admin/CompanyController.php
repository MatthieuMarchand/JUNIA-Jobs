<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return view('admin.companies.index', [
            'users' => User::where('role', UserRole::Company)
                ->whereHas('companyRegistrationRequest', function ($query) {
                    $query->whereApproved(true);
                })
                ->with('companyProfile')
                ->paginate(20),
        ]);
    }

    public function destroy(User $company): RedirectResponse
    {
        Gate::authorize('delete', $company);

        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Entreprise supprimée avec succès.');
    }
}
