<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRegistrationRequest;
use Illuminate\Support\Facades\Gate;
use function view;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        Gate::authorize('view-admin-dashboard');

        return view('admin.dashboard', [
            'companiesApprovedCount' => CompanyRegistrationRequest::whereApproved(true)->count(),
            'companiesRequestsCount' => CompanyRegistrationRequest::whereApproved(false)->count(),
        ]);
    }
}
