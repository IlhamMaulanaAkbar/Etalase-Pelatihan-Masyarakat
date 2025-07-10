<?php

use App\Http\Controllers\Auth\Internal\LoginController;
use App\Http\Controllers\Auth\Internal\RegisterController;
use App\Http\Controllers\Internal\Home\DashboardController;
use App\Http\Controllers\Internal\Page\LearningController;
use App\Http\Controllers\Internal\Page\TrainingController;
use App\Http\Controllers\Internal\Page\TrainingParticipantController;
use App\Http\Controllers\Internal\TestAssessment\PreTestController;
use App\Http\Controllers\Internal\TestAssessment\PostTestController;
use App\Http\Controllers\Internal\Evaluations\TrainingEvaluationController;
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

        Route::get('/training-participants', [TrainingParticipantController::class, 'index'])->name('internal.training.participants.index');
        Route::get('/training-participants/{training}', [TrainingParticipantController::class, 'show'])->name('internal.training.participants.show');
        Route::put('/training-participants/{training_user}', [TrainingParticipantController::class, 'status'])->name('internal.training.participants.status');

        Route::prefix('training/{training}/test-assessment')->group(function () {
            Route::get('/pre-test', [PreTestController::class, 'index'])->name('internal.test-assessment.pre-test.index');
            Route::get('/pre-test/create', [PreTestController::class, 'create'])->name('internal.test-assessment.pre-test.create');
            Route::post('/pre-test', [PreTestController::class, 'store'])->name('internal.test-assessment.pre-test.store');
            Route::get('/pre-test/{pre_test}/edit', [PreTestController::class, 'edit'])->name('internal.test-assessment.pre-test.edit');
            Route::put('/pre-test/{pre_test}', [PreTestController::class, 'update'])->name('internal.test-assessment.pre-test.update');
            Route::delete('/pre-test/{pre_test}', [PreTestController::class, 'destroy'])->name('internal.test-assessment.pre-test.destroy');

            Route::get('/post-test', [PostTestController::class, 'index'])->name('internal.test-assessment.post-test.index');
            Route::get('/post-test/create', [PostTestController::class, 'create'])->name('internal.test-assessment.post-test.create');
            Route::post('/post-test', [PostTestController::class, 'store'])->name('internal.test-assessment.post-test.store');
            Route::get('/post-test/{post_test}/edit', [PostTestController::class, 'edit'])->name('internal.test-assessment.post-test.edit');
            Route::put('/post-test/{post_test}', [PostTestController::class, 'update'])->name('internal.test-assessment.post-test.update');
            Route::delete('/post-test/{post_test}', [PostTestController::class, 'destroy'])->name('internal.test-assessment.post-test.destroy');
        });

        Route::prefix('training/{training}/evaluations')->group(function () {
            Route::get('/training-evaluations', [TrainingEvaluationController::class, 'index'])->name('internal.evaluations.training-evaluation.index');
            Route::get('/training-evaluations/create', [TrainingEvaluationController::class, 'create'])->name('internal.evaluations.training-evaluation.create');
            Route::post('/training-evaluations', [TrainingEvaluationController::class, 'store'])->name('internal.evaluations.training-evaluation.store');
            Route::get('/training-evaluations/{training_evaluation}/edit', [TrainingEvaluationController::class, 'edit'])->name('internal.evaluations.training-evaluation.edit');
            Route::put('/training-evaluations/{training_evaluation}', [TrainingEvaluationController::class, 'update'])->name('internal.evaluations.training-evaluation.update');
            Route::delete('/training-evaluations/{training_evaluation}', [TrainingEvaluationController::class, 'destroy'])->name('internal.evaluations.training-evaluation.destroy');
        });
    });
});
