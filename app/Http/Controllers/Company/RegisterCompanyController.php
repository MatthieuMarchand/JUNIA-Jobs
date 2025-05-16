<?php

namespace App\Http\Controllers\Company;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterCompanyController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', Rule::unique(User::class)],
            'company_name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'gdpr_consent' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make(Str::random()),
            'gdpr_consent' => true,
            'role' => UserRole::Company,
        ]);

        $user->companyRegistrationRequest()->create([
            'company_name' => $validated['company_name'],
            'message' => $validated['message'],
            'approved' => false,
        ]);

        return view('companies.register.waiting');
    }
}
