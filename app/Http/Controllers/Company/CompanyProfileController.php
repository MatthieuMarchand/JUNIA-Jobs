<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
    }
}
