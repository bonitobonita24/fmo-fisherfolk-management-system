<?php

use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

// Statistics API endpoints (protected by auth and permission middleware)
Route::middleware(['auth', 'permission:dashboard.view'])->prefix('stats')->group(function () {
    Route::get('/summary', [StatsController::class, 'summary']);
    Route::get('/barangay', [StatsController::class, 'barangay']);
    Route::get('/gender', [StatsController::class, 'gender']);
    Route::get('/age-group', [StatsController::class, 'ageGroup']);
    Route::get('/category', [StatsController::class, 'category']);
    Route::get('/barangay-category', [StatsController::class, 'barangayCategory']);
});
