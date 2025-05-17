<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRegistrationRequest;
use Illuminate\Support\Facades\Gate;

class CompanyRegisterRequestController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', CompanyRegistrationRequest::class);

        return view('admin.companies.requests', [
            'requests' => CompanyRegistrationRequest::whereApproved(false)->get(),
        ]);
    }
}
