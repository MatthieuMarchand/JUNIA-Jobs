<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function to_route;

class CompanyProfileController extends Controller
{
    public function show()
    {
        return view('students.profile');
    }

    public function edit()
    {
        //
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        $profile = $user->companyProfile()->firstOrNew();

        $profile->name = $validated['name'];
        $profile->description = $validated['description'];

        $profile->save();

        return to_route('companies.profile.edit');
    }
}
