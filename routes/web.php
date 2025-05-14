<?php

use App\Http\Controllers\Student\LoginStudentController;
use App\Http\Controllers\Student\RegisterStudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Compte
Route::prefix('students')->name('students.')->group(static function () {
    Route::resource('login', LoginStudentController::class)->only(['index', 'store']);

    Route::resource('register', RegisterStudentController::class)->only(['index', 'store']);
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
