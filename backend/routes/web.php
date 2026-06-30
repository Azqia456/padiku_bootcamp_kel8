<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Petani
    Route::get('/dashboard/farmers', [DashboardController::class, 'farmers'])->name('dashboard.farmers');
    Route::post('/dashboard/farmers/{id}/approve', [DashboardController::class, 'approveFarmer'])->name('dashboard.farmers.approve');
    Route::post('/dashboard/farmers/{id}/reject', [DashboardController::class, 'rejectFarmer'])->name('dashboard.farmers.reject');
    Route::get('/dashboard/farmers/{id}/edit', [DashboardController::class, 'editFarmer'])->name('dashboard.farmers.edit');
    Route::put('/dashboard/farmers/{id}', [DashboardController::class, 'updateFarmer'])->name('dashboard.farmers.update');
    Route::delete('/dashboard/farmers/{id}', [DashboardController::class, 'destroyFarmer'])->name('dashboard.farmers.destroy');
    
    // Peta & Lahan
    Route::get('/dashboard/map', [DashboardController::class, 'map'])->name('dashboard.map');
    Route::get('/dashboard/plantings', [DashboardController::class, 'plantings'])->name('dashboard.plantings');
    Route::post('/dashboard/plantings', [DashboardController::class, 'storePlanting'])->name('dashboard.plantings.store');
    Route::post('/dashboard/plantings/check-conflict', [DashboardController::class, 'checkHarvestConflict'])->name('dashboard.plantings.check-conflict');
    
    // Hama & Monitoring
    Route::get('/dashboard/pest-monitoring', [DashboardController::class, 'pestMonitoring'])->name('dashboard.pest-monitoring');
    Route::post('/dashboard/pest-reports', [DashboardController::class, 'storePestReport'])->name('dashboard.pest-reports.store');
    
    // Distribusi Pupuk
    Route::get('/dashboard/fertilizer', [DashboardController::class, 'fertilizer'])->name('dashboard.fertilizer');
    Route::post('/dashboard/fertilizer', [DashboardController::class, 'storeFertilizerSchedule'])->name('dashboard.fertilizer.store');
    Route::post('/dashboard/fertilizer-schedules/{id}/notify', [DashboardController::class, 'sendFertilizerNotification'])->name('dashboard.fertilizer.notify');
    
    // Informasi & Analisis
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics'])->name('dashboard.statistics');
    Route::get('/dashboard/food-balance', [DashboardController::class, 'foodBalance'])->name('dashboard.food-balance');
    Route::get('/dashboard/data-analysis', [DashboardController::class, 'dataAnalysis'])->name('dashboard.data-analysis');
    Route::get('/dashboard/notifications-data', [DashboardController::class, 'getNotificationsData'])->name('dashboard.notifications-data');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';