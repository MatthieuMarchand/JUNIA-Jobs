<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
use App\Http\Controllers\Company\RegisterCompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Student\RegisterStudentController;

Route::middleware('guest')->group(function () {
    Route::resource('login', LoginController::class)->only(['index', 'store'])->names([
        'index' => 'login',
    ]);

    Route::get('/reset-password/request', [PasswordResetRequestController::class, 'create'])->name('password-reset.request.create');
    Route::post('/reset-password/request', [PasswordResetRequestController::class, 'store'])->name('password-reset.request.store');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'create'])->name('password-reset.create');
    Route::post('/reset-password', [PasswordResetController::class, 'store'])->name('password-reset.store');

    Route::prefix('companies')->name('companies.')->group(static function () {
        Route::resource('register', RegisterCompanyController::class)->only(['index', 'store']);
    });

    Route::prefix('students')->name('students.')->group(static function () {
        Route::resource('register', RegisterStudentController::class)->only(['index', 'store']);
    });
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');
});
