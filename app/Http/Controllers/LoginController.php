<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function back;
use function to_route;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    private function backWithWrongCredentialsError(): RedirectResponse
    {
        return back()->withErrors(['password' => 'Mot de passe ou email incorrect'])->withInput();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->with('companyRegistrationRequest')->first();
        if (!$user) {
            return $this->backWithWrongCredentialsError();
        }

        if ($user->role === UserRole::Company && !$user->companyRegistrationRequest?->approved) {
            return back()->withErrors(['email' => 'Votre compte n\'est pas encore approuvé'])->withInput();
        }

        $authenticated = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (!$authenticated) {
            return $this->backWithWrongCredentialsError();
        }

        return match ($user->role) {
            UserRole::Student => to_route('students.profile.show'),
            UserRole::Company => to_route('companies.profile.show'),
            //            UserRole::Admin => to_route('admin.dashboard'),
        };
    }
}
