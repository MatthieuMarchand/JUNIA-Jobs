<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use function back;
use function view;

class PasswordResetRequestController extends Controller
{
    public function create()
    {
        return view('auth.reset-password-request');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink($validated);

        return back()->with('success', "Un mail a été envoyé à {$validated['email']} si un compte utilisateur existe avec cette adresse.");
    }
}
