<?php

use App\Http\Controllers\Auth\Internal\LoginController;
use App\Http\Controllers\Auth\Internal\RegisterController;
use App\Http\Controllers\Internal\Home\DashboardController;
use App\Http\Controllers\Internal\Page\LearningController;
use App\Http\Controllers\Internal\Page\TrainingController;
use Illuminate\Support\Facades\Route;

Route::prefix('internal')->group(function () {
    Route::middleware(['guest:internal'])->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('auth.internal.login.index');
        Route::post('/login', [LoginController::class, 'store'])->name('auth.internal.login.store');
        Route::get('/register', [RegisterController::class, 'index'])->name('auth.internal.register.index');
        Route::post('register', [RegisterController::class, 'store'])->name('auth.internal.register.store');
    });

    Route::middleware(['auth:internal'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('internal.home.dashboard.index');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('auth.internal.logout.destroy');

        Route::get('/learning', [LearningController::class, 'index'])->name('internal.learning.index');
        Route::get('/learning/create', [LearningController::class, 'create'])->name('internal.learning.create');
        Route::post('/learning', [LearningController::class, 'store'])->name('internal.learning.store');
        Route::get('/learning/{learning}/edit', [LearningController::class, 'edit'])->name('internal.learning.edit');
        Route::put('/learning/{learning}', [LearningController::class, 'update'])->name('internal.learning.update');
        Route::get('/learning/{learning}', [LearningController::class, 'show'])->name('internal.learning.show');
        Route::delete('/learning/{learning}', [LearningController::class, 'destroy'])->name('internal.learning.destroy');

        Route::get('/training', [TrainingController::class, 'index'])->name('internal.training.index');
        Route::get('/training/create', [TrainingController::class, 'create'])->name('internal.training.create');
        Route::post('/training', [TrainingController::class, 'store'])->name('internal.training.store');
        Route::get('/training/{training}/edit', [TrainingController::class, 'edit'])->name('internal.training.edit');
        Route::put('/training/{training}', [TrainingController::class, 'update'])->name('internal.training.update');
        Route::get('/training/{training}', [TrainingController::class, 'show'])->name('internal.training.show');
        Route::delete('/training/{training}', [TrainingController::class, 'destroy'])->name('internal.training.destroy');
    });
});
