<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\RegisterCompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Student\RegisterStudentController;
use App\Http\Controllers\Student\StudentProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::resource('login', LoginController::class)->only(['index', 'store'])->names([
        'index' => 'login',
    ]);

    Route::get('/reset-password/request', [PasswordResetRequestController::class, 'create'])->name('password-reset.request.create');
    Route::post('/reset-password/request', [PasswordResetRequestController::class, 'store'])->name('password-reset.request.store');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'create'])->name('password-reset.create');
    Route::post('/reset-password', [PasswordResetController::class, 'store'])->name('password-reset.store');
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');
});

Route::prefix('students')->name('students.')->group(static function () {
    Route::middleware('guest')->group(function () {
        Route::resource('register', RegisterStudentController::class)->only(['index', 'store']);
    });

    Route::middleware('auth:web')->group(function () {
        Route::singleton('profile', StudentProfileController::class)->only(['show', 'edit', 'update']);
        // Get all student's profiles
        Route::get('/profiles', [StudentProfileController::class, 'index']);
    });
});

Route::prefix('companies')->name('companies.')->group(static function () {
    Route::middleware('guest')->group(function () {
        Route::resource('register', RegisterCompanyController::class)->only(['index', 'store']);
    });

    Route::middleware('auth:web')->group(function () {
        Route::singleton('profile', CompanyProfileController::class)->only(['show', 'edit', 'update']);
    });
});


