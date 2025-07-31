<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\PreTestUsersAnswers;
use App\Models\PostTestUsersAnswers;
use App\Models\PreTestAnswers;
use App\Models\PostTestAnswers;
use App\Models\TrainingUser;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainingParticipantsReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingUser::with(['user', 'training.category'])
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->year, function ($q) use ($request) {
                $q->whereHas('training', function ($tq) use ($request) {
                    $tq->whereYear('start_date', $request->year);
                });
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereHas('training', function ($tq) use ($request) {
                    $tq->whereMonth('start_date', $request->month);
                });
            });

        $participants = $query->get();

        foreach ($participants as $participant) {
            $training = $participant->training;

            // PRE-TEST
            $preTestQuestionIds = $training->preTestQuestions->pluck('id');
            $userPreAnswers = PreTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('pre_test_questions_id', $preTestQuestionIds)
                ->whereNotNull('answer')->get();

            $correctPre = 0;
            foreach ($userPreAnswers as $answer) {
                $isCorrect = PreTestAnswers::where('pre_test_questions_id', $answer->pre_test_questions_id)
                    ->where('answer', $answer->answer)
                    ->where('is_correct', true)->exists();
                if ($isCorrect) $correctPre++;
            }

            $participant->pre_test_score = $preTestQuestionIds->count() > 0
                ? round(($correctPre / $preTestQuestionIds->count()) * 100)
                : null;

            // POST-TEST
            $postTestQuestionIds = $training->postTestQuestions->pluck('id');
            $userPostAnswers = PostTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('post_test_questions_id', $postTestQuestionIds)
                ->whereNotNull('answer')->get();

            $correctPost = 0;
            foreach ($userPostAnswers as $answer) {
                $isCorrect = PostTestAnswers::where('post_test_questions_id', $answer->post_test_questions_id)
                    ->where('answer', $answer->answer)
                    ->where('is_correct', true)->exists();
                if ($isCorrect) $correctPost++;
            }

            $participant->post_test_score = $postTestQuestionIds->count() > 0
                ? round(($correctPost / $postTestQuestionIds->count()) * 100)
                : null;
        }

        // Untuk dropdown tahun & bulan
        $years = Training::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');
        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        return view('internal.report.training-participants-report.index', [
            'participants' => $participants,
            'years' => $years,
            'months' => $months,
            'request' => $request
        ]);
    }

    public function print(Request $request)
    {
        $query = TrainingUser::with(['user', 'training.category'])
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->year, function ($q) use ($request) {
                $q->whereHas('training', function ($tq) use ($request) {
                    $tq->whereYear('start_date', $request->year);
                });
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereHas('training', function ($tq) use ($request) {
                    $tq->whereMonth('start_date', $request->month);
                });
            });

        $participants = $query->get();

        foreach ($participants as $participant) {
            $training = $participant->training;

            // PRE-TEST
            $preTestQuestionIds = $training->preTestQuestions->pluck('id');
            $userPreAnswers = PreTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('pre_test_questions_id', $preTestQuestionIds)
                ->whereNotNull('answer')->get();

            $correctPre = 0;
            foreach ($userPreAnswers as $answer) {
                $isCorrect = PreTestAnswers::where('pre_test_questions_id', $answer->pre_test_questions_id)
                    ->where('answer', $answer->answer)
                    ->where('is_correct', true)->exists();
                if ($isCorrect) $correctPre++;
            }

            $participant->pre_test_score = $preTestQuestionIds->count() > 0
                ? round(($correctPre / $preTestQuestionIds->count()) * 100)
                : null;

            // POST-TEST
            $postTestQuestionIds = $training->postTestQuestions->pluck('id');
            $userPostAnswers = PostTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('post_test_questions_id', $postTestQuestionIds)
                ->whereNotNull('answer')->get();

            $correctPost = 0;
            foreach ($userPostAnswers as $answer) {
                $isCorrect = PostTestAnswers::where('post_test_questions_id', $answer->post_test_questions_id)
                    ->where('answer', $answer->answer)
                    ->where('is_correct', true)->exists();
                if ($isCorrect) $correctPost++;
}

            $participant->post_test_score = $postTestQuestionIds->count() > 0
                ? round(($correctPost / $postTestQuestionIds->count()) * 100)
                : null;
        }

        // Untuk dropdown tahun & bulan
        $years = Training::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');
        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $pdf = Pdf::loadView('internal.report.training-participants-report.print', [
            'participants' => $participants,
            'years' => $years,
            'months' => $months,
            'request' => $request
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('training-participants-report.pdf');
    }
}