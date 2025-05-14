<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterStudentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
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
        ]);

        Auth::login($user);
    }
}
