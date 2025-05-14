<?php

use App\Http\Controllers\Student\LoginStudentController;
use App\Http\Controllers\Student\RegisterStudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Compte
Route::prefix('students')->name('students.')->group(static function () {
    Route::get('/login', [LoginStudentController::class, 'index'])->name('login');
    Route::post('/login', [LoginStudentController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterStudentController::class, 'index'])->name('register');
    Route::post('/register', [RegisterStudentController::class, 'store'])->name('register.store');

    Route::get('/profile', [])->name('profile');
    Route::put('/profile', [])->name('profile.update');
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
