<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/farmers', [DashboardController::class, 'farmers'])->name('dashboard.farmers');
    Route::post('/dashboard/farmers', [DashboardController::class, 'storeFarmer'])->name('dashboard.farmers.store');
    Route::get('/dashboard/map', [DashboardController::class, 'map'])->name('dashboard.map');
    Route::get('/dashboard/plantings', [DashboardController::class, 'plantings'])->name('dashboard.plantings');
    Route::post('/dashboard/plantings', [DashboardController::class, 'storePlanting'])->name('dashboard.plantings.store');
    Route::get('/dashboard/pest-monitoring', [DashboardController::class, 'pestMonitoring'])->name('dashboard.pest-monitoring');
    Route::post('/dashboard/pest-reports', [DashboardController::class, 'storePestReport'])->name('dashboard.pest-reports.store');
    Route::get('/dashboard/fertilizer', [DashboardController::class, 'fertilizer'])->name('dashboard.fertilizer');
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');
    Route::get('/dashboard/food-balance', [DashboardController::class, 'foodBalance'])->name('dashboard.food-balance');
    Route::get('/dashboard/data-analysis', [DashboardController::class, 'dataAnalysis'])->name('dashboard.data-analysis');
    Route::get('/dashboard/early-warning', [DashboardController::class, 'earlyWarning'])->name('dashboard.early-warning');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
