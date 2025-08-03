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
use App\Http\Controllers\Internal\Evaluations\InstructorEvaluationController;
use App\Http\Controllers\Internal\Page\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\Page\TrainingEvaluationController as EvaluationTrainingController;
use App\Http\Controllers\Internal\Page\InstructorEvaluationController as EvaluationInstructorController;
use App\Http\Controllers\Internal\Page\AssistanceController;
use App\Http\Controllers\Internal\Page\AssistanceParticipantController;
use App\Http\Controllers\Internal\Report\TrainingReportController;
use App\Http\Controllers\Internal\Report\AssistanceReportController;
use App\Http\Controllers\Internal\Report\LearningReportController;
use App\Http\Controllers\Internal\Report\TrainingParticipantsReportController;
use App\Http\Controllers\Internal\Report\AssistanceParticipantsReportController;
use App\Http\Controllers\Internal\Report\UsersReportController;
use App\Http\Controllers\Internal\Report\TrainingEvaluationReportController;
use App\Http\Controllers\Internal\Report\InstructorEvaluationReportController;
use App\Http\Controllers\Internal\Lessons\TrainingLessonsController;
use App\Http\Controllers\Internal\Lessons\AssistanceLessonsController;
use App\Http\Controllers\Internal\Certificates\CertificatesController;



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

        Route::get('/assistance', [AssistanceController::class, 'index'])->name('internal.assistance.index');
        Route::get('/assistance/create', [AssistanceController::class, 'create'])->name('internal.assistance.create');
        Route::post('/assistance', [AssistanceController::class, 'store'])->name('internal.assistance.store');
        Route::get('/assistance/{assistance}/edit', [AssistanceController::class, 'edit'])->name('internal.assistance.edit');
        Route::put('/assistance/{assistance}', [AssistanceController::class, 'update'])->name('internal.assistance.update');
        Route::get('/assistance/{assistance}', [AssistanceController::class, 'show'])->name('internal.assistance.show');
        Route::delete('/assistance/{assistance}', [AssistanceController::class, 'destroy'])->name('internal.assistance.destroy');

        Route::get('/training-participants', [TrainingParticipantController::class, 'index'])->name('internal.training.participants.index');
        Route::get('/training-participants/{training}', [TrainingParticipantController::class, 'show'])->name('internal.training.participants.show');
        Route::put('/training-participants/{training_user}', [TrainingParticipantController::class, 'status'])->name('internal.training.participants.status');

        Route::get('/assistance-participants', [AssistanceParticipantController::class, 'index'])->name('internal.assistance.participants.index');
        Route::get('/assistance-participants/{assistance}', [AssistanceParticipantController::class, 'show'])->name('internal.assistance.participants.show');
        Route::put('/assistance-participants/{assistance_user}', [AssistanceParticipantController::class, 'status'])->name('internal.assistance.participants.status');

        Route::get('/evaluations/training-evaluations', [EvaluationTrainingController::class, 'index'])->name('internal.page.training-evaluation.index');
        Route::get('/evaluations/training-evaluations/{training}', [EvaluationTrainingController::class, 'show'])->name('internal.page.training-evaluation.show');
        Route::get('/evaluations/instructor-evaluations', [EvaluationInstructorController::class, 'index'])->name('internal.page.instructor-evaluation.index');
        Route::get('/evaluations/instructor-evaluations/{training}', [EvaluationInstructorController::class, 'show'])->name('internal.page.instructor-evaluation.show');

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

            Route::get('/instructor-evaluations', [InstructorEvaluationController::class, 'index'])->name('internal.evaluations.instructor-evaluation.index');
            Route::get('/instructor-evaluations/create', [InstructorEvaluationController::class, 'create'])->name('internal.evaluations.instructor-evaluation.create');
            Route::post('/instructor-evaluations', [InstructorEvaluationController::class, 'store'])->name('internal.evaluations.instructor-evaluation.store');
            Route::get('/instructor-evaluations/{instructor_evaluation}/edit', [InstructorEvaluationController::class, 'edit'])->name('internal.evaluations.instructor-evaluation.edit');
            Route::put('/instructor-evaluations/{instructor_evaluation}', [InstructorEvaluationController::class, 'update'])->name('internal.evaluations.instructor-evaluation.update');
            Route::delete('/instructor-evaluations/{instructor_evaluation}', [InstructorEvaluationController::class, 'destroy'])->name('internal.evaluations.instructor-evaluation.destroy');
        });

        Route::prefix('training/{training}/training-lessons')->group(function () {
            Route::get('/', [TrainingLessonsController::class, 'index'])->name('internal.lessons.training.index');
            Route::get('/create', [TrainingLessonsController::class, 'create'])->name('internal.lessons.training.create');
            Route::post('/', [TrainingLessonsController::class, 'store'])->name('internal.lessons.training.store');
            Route::get('/{lesson}/edit', [TrainingLessonsController::class, 'edit'])->name('internal.lessons.training.edit');
            Route::put('/{lesson}', [TrainingLessonsController::class, 'update'])->name('internal.lessons.training.update');
            Route::delete('/{lesson}', [TrainingLessonsController::class, 'destroy'])->name('internal.lessons.training.destroy');
        });

        Route::prefix('assistance/{assistance}/lessons-assistance')->group(function () {
            Route::get('/', [AssistanceLessonsController::class, 'index'])->name('internal.lessons.assistance.index');
            Route::get('/create', [AssistanceLessonsController::class, 'create'])->name('internal.lessons.assistance.create');
            Route::post('/', [AssistanceLessonsController::class, 'store'])->name('internal.lessons.assistance.store');
            Route::get('/{lesson}/edit', [AssistanceLessonsController::class, 'edit'])->name('internal.lessons.assistance.edit');
            Route::put('/{lesson}', [AssistanceLessonsController::class, 'update'])->name('internal.lessons.assistance.update');
            Route::delete('/{lesson}', [AssistanceLessonsController::class, 'destroy'])->name('internal.lessons.assistance.destroy');
        });

        Route::prefix('/training/{training}/certificates')->group(function () {
            Route::get('/', [CertificatesController::class, 'index'])->name('internal.certificates.index');
            Route::get('/create', [CertificatesController::class, 'create'])->name('internal.certificates.create');
            Route::post('/', [CertificatesController::class, 'store'])->name('internal.certificates.store');
            Route::get('/{certificate}/edit', [CertificatesController::class, 'edit'])->name('internal.certificates.edit');
            Route::put('/{certificate}', [CertificatesController::class, 'update'])->name('internal.certificates.update');
            Route::delete('/{certificate}', [CertificatesController::class, 'destroy'])->name('internal.certificates.destroy');
        });

        Route::prefix('report')->group(function () {
            Route::get('/training-report', [TrainingReportController::class, 'index'])->name('internal.report.training-report.index');
            Route::get('/training-report/print', [TrainingReportController::class, 'print'])->name('internal.report.training-report.print');
            Route::get('/assistance-report', [AssistanceReportController::class, 'index'])->name('internal.report.assistance-report.index');
            Route::get('/assistance-report/print', [AssistanceReportController::class, 'print'])->name('internal.report.assistance-report.print');
            Route::get('/learning-report', [LearningReportController::class, 'index'])->name('internal.report.learning-report.index');
            Route::get('/learning-report/print', [LearningReportController::class, 'print'])->name('internal.report.learning-report.print');
            Route::get('/training-participants-report', [TrainingParticipantsReportController::class, 'index'])->name('internal.report.training-participants-report.index');
            Route::get('/training-participants-report/print', [TrainingParticipantsReportController::class, 'print'])->name('internal.report.training-participants-report.print');
            Route::get('/assistance-participants-report', [AssistanceParticipantsReportController::class, 'index'])->name('internal.report.assistance-participants-report.index');
            Route::get('/assistance-participants-report/print', [AssistanceParticipantsReportController::class, 'print'])->name('internal.report.assistance-participants-report.print');
            Route::get('/users-report', [UsersReportController::class, 'index'])->name('internal.report.users-report.index');
            Route::get('/users-report/print', [UsersReportController::class, 'print'])->name('internal.report.users-report.print');
            Route::get('/training-evaluations-report', [TrainingEvaluationReportController::class, 'index'])->name('internal.report.training-evaluations-report.index');
            Route::get('/training-evaluations-report/print', [TrainingEvaluationReportController::class, 'print'])->name('internal.report.training-evaluations-report.print');
            Route::get('/instructor-evaluations-report', [InstructorEvaluationReportController::class, 'index'])->name('internal.report.instructor-evaluations-report.index');
            Route::get('/instructor-evaluations-report/print', [InstructorEvaluationReportController::class, 'print'])->name('internal.report.instructor-evaluations-report.print');
        });

        Route::get('/users', [UsersController::class, 'index'])->name('internal.users.index');
    });
});
