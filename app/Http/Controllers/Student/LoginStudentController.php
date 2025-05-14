<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function abort;

class LoginStudentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'email|required',
            'password' => 'string|required',
        ]);

        $authenticated = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (!$authenticated) {
            abort(403);
        }
    }
}
