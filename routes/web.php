<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Student\RegisterStudentController;
use App\Http\Controllers\Student\StudentProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::resource('login', LoginController::class)->only(['index', 'store']);
});

Route::prefix('students')->name('students.')->group(static function () {
    Route::middleware('guest')->group(function () {
        Route::resource('register', RegisterStudentController::class)->only(['index', 'store']);
    });

    Route::middleware('auth:web')->group(function () {
        Route::singleton('profile', StudentProfileController::class)->only(['show', 'edit', 'update']);
    });
});

Route::get('/cv', []);

// Profils
Route::get('/profiles', []);
Route::get('/profiles/convoques', []);

Route::get('/contact', []);
Route::post('/contact', []);

Route::get('/admin/users', []);
Route::get('/admin/companies', []);
Route::post('/admin/companies', []);
