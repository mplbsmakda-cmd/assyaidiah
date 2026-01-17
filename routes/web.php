<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Rute Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', [StudentController::class, 'createPublic'])->name('register');
Route::post('/register', [StudentController::class, 'storePublic']);

// Rute Autentikasi
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang Dilindungi (Hanya untuk Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class)->except(['create', 'store']);
    Route::resource('guardians', GuardianController::class);
});
