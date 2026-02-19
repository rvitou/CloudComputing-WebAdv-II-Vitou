<?php

use Illuminate\Support\Facades\Route;

// Import all the controllers (without the 'Admin' subfolder)
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PayoutController;


// --- AUTHENTICATION ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// --- ADMIN PANEL ---
Route::middleware('auth')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('coaches', CoachController::class);
    Route::resource('exercises', ExerciseController::class)->only(['index', 'show', 'destroy']);
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
    Route::post('payouts/{subscription}', [PayoutController::class, 'store'])->name('payouts.store');

});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
