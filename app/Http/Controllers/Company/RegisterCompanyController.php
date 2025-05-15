<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function to_route;

class RegisterCompanyController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required', 'string', 'confirmed'],
            'gdpr_consent' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gdpr_consent' => true,
            'role' => UserRole::Company,
        ]);

        Auth::login($user);

        return to_route('companies.profile.edit');
    }
}
