<?php

namespace App\Http\Controllers\Student;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function to_route;

class RegisterStudentController extends Controller
{
    public function index()
    {
        return view('students.register');
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
            'role' => UserRole::Student,
        ]);

        Auth::login($user);

        return to_route('students.profile.edit');
    }
}
