<?php

use App\Http\Controllers\User\Page\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\User\Home\DashboardController;
use App\Http\Controllers\User\Page\TrainingController;
use App\Http\Controllers\User\Page\ContactController;
use App\Http\Controllers\User\Page\LearningController;
use App\Http\Controllers\User\Account\ProfileController;


Route::get('/', [DashboardController::class, 'index'])->name('public.home.dashboard.index');
Route::get('/training', [TrainingController::class, 'index'])->name('public.training.index');
Route::get('/training/{training}', [TrainingController::class, 'show'])->name('public.training.show');
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
});
