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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/farmers', [DashboardController::class, 'farmers'])->name('dashboard.farmers');
Route::get('/dashboard/map', [DashboardController::class, 'map'])->name('dashboard.map');
Route::get('/dashboard/plantings', [DashboardController::class, 'plantings'])->name('dashboard.plantings');
Route::get('/dashboard/pest-monitoring', [DashboardController::class, 'pestMonitoring'])->name('dashboard.pest-monitoring');
Route::get('/dashboard/fertilizer', [DashboardController::class, 'fertilizer'])->name('dashboard.fertilizer');
Route::get('/dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');
Route::get('/dashboard/food-balance', [DashboardController::class, 'foodBalance'])->name('dashboard.food-balance');
Route::get('/dashboard/data-analysis', [DashboardController::class, 'dataAnalysis'])->name('dashboard.data-analysis');
Route::get('/dashboard/early-warning', [DashboardController::class, 'earlyWarning'])->name('dashboard.early-warning');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
