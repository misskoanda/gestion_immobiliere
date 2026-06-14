<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route redirects based on role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Role-specific dashboards
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [DashboardController::class, 'client'])->name('client.dashboard');
});

Route::middleware(['auth', 'role:bailleur'])->group(function () {
    Route::get('/bailleur/dashboard', [DashboardController::class, 'bailleur'])->name('bailleur.dashboard');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [DashboardController::class, 'manager'])->name('manager.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
