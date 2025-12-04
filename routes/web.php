<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FisherfolkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard route with permission check
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.view'])
    ->name('dashboard');

// Fisherfolk routes with permission checks
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/fisherfolk', [FisherfolkController::class, 'index'])
        ->middleware('permission:fisherfolk.view')
        ->name('fisherfolk.index');
    
    Route::get('/fisherfolk/create', [FisherfolkController::class, 'create'])
        ->middleware('permission:fisherfolk.create')
        ->name('fisherfolk.create');
    
    Route::post('/fisherfolk', [FisherfolkController::class, 'store'])
        ->middleware('permission:fisherfolk.create')
        ->name('fisherfolk.store');
    
    Route::get('/fisherfolk/{id}', [FisherfolkController::class, 'show'])
        ->middleware('permission:fisherfolk.view')
        ->name('fisherfolk.show');
    
    Route::get('/fisherfolk/{id}/edit', [FisherfolkController::class, 'edit'])
        ->middleware('permission:fisherfolk.update')
        ->name('fisherfolk.edit');
    
    Route::put('/fisherfolk/{id}', [FisherfolkController::class, 'update'])
        ->middleware('permission:fisherfolk.update')
        ->name('fisherfolk.update');
    
    Route::delete('/fisherfolk/{id}', [FisherfolkController::class, 'destroy'])
        ->middleware('permission:fisherfolk.delete')
        ->name('fisherfolk.destroy');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
