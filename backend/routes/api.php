<?php

use App\Http\Controllers\Api\PlantingController;
use App\Http\Controllers\Api\PestReportController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\FertilizerScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);

// Mobile App API Routes
Route::middleware('auth:sanctum')->group(function () {
    // Planting routes
    Route::apiResource('plantings', PlantingController::class);
    
    // Pest Report routes
    Route::apiResource('pest-reports', PestReportController::class);
    
    // Notification routes
    Route::apiResource('notifications', NotificationController::class);
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    
    // Recommendation routes
    Route::apiResource('recommendations', RecommendationController::class);
    
    // Fertilizer Schedule routes
    Route::apiResource('fertilizer-schedules', FertilizerScheduleController::class);
});
