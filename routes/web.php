<?php

use App\Http\Controllers\Student\LoginStudentController;
use App\Http\Controllers\Student\RegisterStudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Compte
Route::group([
    'prefix' => 'students',
    'namespace' => 'students.',
], static function () {
    Route::get('/login', [LoginStudentController::class, 'index']);
    Route::post('/login', [LoginStudentController::class, 'store']);

    Route::get('/register', [RegisterStudentController::class, 'index']);
    Route::post('/register', [RegisterStudentController::class, 'store']);
});

Route::get('/profile', []);
Route::put('/profile', []);

Route::get('/cv', []);

// Profils
Route::get('/profiles', []);
Route::get('/profiles/convoques', []);

Route::get('/contact', []);
Route::post('/contact', []);

Route::get('/admin/users', []);
Route::get('/admin/companies', []);
Route::post('/admin/companies', []);
