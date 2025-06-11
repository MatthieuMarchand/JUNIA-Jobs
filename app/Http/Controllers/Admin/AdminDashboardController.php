<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\CompanyRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use function view;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        Gate::authorize('view-admin-dashboard');

        return view('admin.dashboard', [
            'studentsCount' => User::where('role', UserRole::Student)->count(),
            'companiesApprovedCount' => CompanyRegistrationRequest::whereApproved(true)->count(),
            'companiesRequestsCount' => CompanyRegistrationRequest::whereApproved(false)->count(),
        ]);
    }
}
