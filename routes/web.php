<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UpdateTaskStatusController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('projects.show');

        Route::apiResource('projects.tasks', TaskController::class)
            ->shallow()
            ->only(['store', 'update', 'destroy']);
        Route::patch('/tasks/update-status', UpdateTaskStatusController::class)->name('tasks.update-status');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
