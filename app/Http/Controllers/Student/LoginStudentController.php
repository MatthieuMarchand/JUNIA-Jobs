<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function abort;
use function to_route;

class LoginStudentController extends Controller
{
    public function index()
    {
        return view('students.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $authenticated = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (!$authenticated) {
            return back()->withErrors(['password'=>'Mot de passe incorrect'])->withInput();
        }

        return to_route('students.profile.show');
    }
}
