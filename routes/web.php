<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ApproveCompanyRegisterRequestController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyRegisterRequestController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Company\CompanyInvitationHistoryController;
use App\Http\Controllers\Company\CompanyInviteStudentController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\ListStudentsProfilesController;
use App\Http\Controllers\Company\ShowStudentProfileController;
use App\Http\Controllers\Student\AcademicRecordController;
use App\Http\Controllers\Student\ImportLinkedinPdfController;
use App\Http\Controllers\Student\ProfessionalExperienceController;
use App\Http\Controllers\Student\StudentAcceptInvitationController;
use App\Http\Controllers\Student\StudentDeclineInvitationController;
use App\Http\Controllers\Student\StudentInvitationHistoryController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/auth.php';

Route::get('/', function () {
    return view('index', [
        'companiesCount' => CompanyProfile::count(),
        'studentsCount' => StudentProfile::count(),
        'companiesWithLogo' => CompanyProfile::whereNotNull('photo_path')->get(),
    ]);
})->name('home');

Route::get('/legal', function () {
    return view('legal.index');
})->name('legal.index');

Route::get('/legal/conditions-of-use', function () {
    return view('legal.conditions-of-use');
})->name('legal.conditions-of-use');

Route::get('/legal/gdpr', function () {
    return view('legal.gdpr');
})->name('legal.gdpr');

Route::middleware('auth:web')->group(function () {
    Route::prefix('students')->name('students.')->group(static function () {
        Route::singleton('profile', StudentProfileController::class)->only(['show', 'edit', 'update']);
        Route::post('profile/import/linkedin', ImportLinkedinPdfController::class)->name('profile.import.linkedin');
        Route::prefix('profile')->name('profile.')->group(static function () {
            Route::resource('professional-experiences', ProfessionalExperienceController::class);
            Route::resource('academic-records', AcademicRecordController::class);
        });

        Route::get('/invitations/history', StudentInvitationHistoryController::class)
            ->name('invitations.history');
        Route::post('/invitations/{invitation}/accept', StudentAcceptInvitationController::class)
            ->name('invitations.accept');
        Route::post('/invitations/{invitation}/decline', StudentDeclineInvitationController::class)
            ->name('invitations.decline');
    });

    Route::prefix('companies')->name('companies.')->group(static function () {
        Route::singleton('profile', CompanyProfileController::class)->only(['show', 'edit', 'update']);
        Route::get('/students', ListStudentsProfilesController::class)->name('students');

        Route::get('/students/{studentProfile}', ShowStudentProfileController::class)
            ->name('students.show');

        Route::post('/students/{studentProfile}/invite', CompanyInviteStudentController::class)
            ->name('students.invite');

        Route::get('/invitations', CompanyInvitationHistoryController::class)
            ->name('invitations.history');
    });

    Route::prefix('admin')->name('admin.')->group(static function () {
        Route::get('/', AdminDashboardController::class)
            ->name('home');

        Route::resource('students', StudentController::class)->only(['index', 'destroy']);

        Route::resource('companies', CompanyController::class)->only(['index', 'destroy']);

        Route::get('/companies/requests', [CompanyRegisterRequestController::class, 'index'])
            ->name('companies.requests.index');
        Route::post('/companies/requests/{registrationRequest}/approve', ApproveCompanyRegisterRequestController::class)
            ->name('companies.requests.approve');
    });
});
