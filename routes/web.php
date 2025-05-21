<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ApproveCompanyRegisterRequestController;
use App\Http\Controllers\Admin\CompanyRegisterRequestController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Student\ProfessionalExperienceController;
use App\Http\Controllers\Student\StudentProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/auth.php';

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('auth:web')->group(function () {
    Route::prefix('students')->name('students.')->group(static function () {
        Route::singleton('profile', StudentProfileController::class)->only(['show', 'edit', 'update']);
        Route::prefix('profile')->name('profile.')->group(static function () {
            Route::resource('professional-experiences', ProfessionalExperienceController::class);
        });

        // Get all student's profiles
        Route::get('/profiles', [StudentProfileController::class, 'index']);
    });

    Route::prefix('companies')->name('companies.')->group(static function () {
        Route::singleton('profile', CompanyProfileController::class)->only(['show', 'edit', 'update']);
    });

    Route::prefix('admin')->name('admin.')->group(static function () {
        Route::get('/', AdminDashboardController::class)
            ->name('home');

        Route::get('/companies/requests', [CompanyRegisterRequestController::class, 'index'])
            ->name('companies.requests.index');
        Route::post('/companies/requests/{registrationRequest}/approve', ApproveCompanyRegisterRequestController::class)
            ->name('companies.requests.approve');
    });
});



