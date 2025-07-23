<?php

use App\Http\Controllers\User\Page\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Internal\Page\InstructorEvaluationController;
use App\Http\Controllers\User\Home\DashboardController;
use App\Http\Controllers\User\Page\TrainingController;
use App\Http\Controllers\User\Page\ContactController;
use App\Http\Controllers\User\Page\LearningController;
use App\Http\Controllers\User\Account\ProfileController;
use App\Http\Controllers\User\Evaluations\InstructorEvaluationController as EvaluationsInstructorController;
use App\Http\Controllers\User\TestAssessment\PreTestController;
use App\Http\Controllers\User\TestAssessment\PostTestController;
use App\Http\Controllers\User\Evaluations\TrainingEvaluationController;
use App\Http\Controllers\User\Page\AssistanceController;


Route::get('/', [DashboardController::class, 'index'])->name('public.home.dashboard.index');
Route::get('/training', [TrainingController::class, 'index'])->name('public.training.index');
Route::get('/training/{training}', [TrainingController::class, 'show'])->name('public.training.show');
Route::get('/assistance', [AssistanceController::class, 'index'])->name('public.assistance.index');
Route::get('/assistance/{assistance}', [AssistanceController::class, 'show'])->name('public.assistance.show');
Route::get('/about', [AboutController::class, 'index'])->name('public.about.index');
Route::get('/contact', [ContactController::class, 'index'])->name('public.contact.index');
Route::get('/learning', [LearningController::class, 'index'])->name('public.learning.index');

Route::middleware(['guest:user'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('auth.user.login.index');
    Route::post('/login', [LoginController::class, 'store'])->name('auth.user.login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('auth.user.register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('auth.user.register.store');

    Route::get('login/oauth/{provider}', [LoginController::class, 'oAuthRedirect'])->name('auth.user.login.oauth.redirect');
    Route::get('login/oauth/{provider}/callback', [LoginController::class, 'oAuthCallback'])->name('auth.user.login.oauth.callback');
});

Route::middleware(['auth:user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('auth.user.logout.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('public.account.profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('public.account.profile.update');
    Route::post('/training/{training}/register', [TrainingController::class, 'register'])->name('public.training.register');
    Route::get('/training/{training}/success', [TrainingController::class, 'success'])->name('public.training.success');
    Route::delete('/training/{training_user}', [TrainingController::class, 'destroy'])->name('public.training.destroy');

    Route::prefix('training/{training}/test-assessment')->group(function () {
        Route::get('/pre-test/start', [PreTestController::class, 'start'])->name('public.test-assessment.pre-test.start');
        Route::get('/pre-test', [PreTestController::class, 'ongoing'])->name('public.test-assessment.pre-test.ongoing');
        Route::post('/pre-test', [PreTestController::class, 'submit'])->name('public.test-assessment.pre-test.submit');
        Route::get('/post-test/start', [PostTestController::class, 'start'])->name('public.test-assessment.post-test.start');
        Route::get('/post-test', [PostTestController::class, 'ongoing'])->name('public.test-assessment.post-test.ongoing');
        Route::post('/post-test', [PostTestController::class, 'submit'])->name('public.test-assessment.post-test.submit');
    });

    Route::prefix('training/{training}/evaluations')->group(function () {
        Route::get('/training-evaluation/start', [TrainingEvaluationController::class, 'start'])->name('public.evaluations.training.start');
        Route::get('/training-evaluation/ongoing', [TrainingEvaluationController::class, 'ongoing'])->name('public.evaluations.training.ongoing');
        Route::post('/training-evaluation/submit', [TrainingEvaluationController::class, 'submit'])->name('public.evaluations.training.submit');

        Route::get('/instructor-evaluation/start', [EvaluationsInstructorController::class, 'start'])->name('public.evaluations.instructor.start');
        Route::get('/instructor-evaluation', [EvaluationsInstructorController::class, 'ongoing'])->name('public.evaluations.instructor.ongoing');
        Route::post('/instructor-evaluation', [EvaluationsInstructorController::class, 'submit'])->name('public.evaluations.instructor.submit');

    });
});
