<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use function back;
use function event;
use function redirect;
use function view;

class PasswordResetController extends Controller
{
    public function create(Request $request, string $token)
    {
        $request->validate([
            'email' => 'nullable|email',
        ]);

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->get('email'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès.')
            : back()->withErrors(['email' => "Les informations fournies ne sont pas valides."]);
    }
}
