<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use function to_route;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        if ($user?->role === UserRole::Administrator) {
            return to_route('admin.home');
        }

        if ($user?->role === UserRole::Student) {
            return to_route('students.profile.show');
        }

        if ($user?->role === UserRole::Company) {
            return to_route('companies.profile.show');
        }

        return view('index', [
            'companiesCount' => CompanyProfile::count(),
            'studentsCount' => StudentProfile::count(),
            'companiesWithLogo' => CompanyProfile::whereNotNull('photo_path')->get(),
        ]);
    }
}
