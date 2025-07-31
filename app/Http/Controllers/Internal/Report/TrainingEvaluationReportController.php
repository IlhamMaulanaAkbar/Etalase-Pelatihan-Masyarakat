<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingEvaluationQuestions;
use App\Models\TrainingEvaluationUsersAnswers;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainingEvaluationReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::with('category')
            ->withCount('participants');

        // Filter berdasarkan tahun dan bulan (start_date)
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        // Ambil data sebagai Collection
        $trainings = $query->get()->map(function ($training) {
            // Evaluasi Skala
            $scaleQuestionIds = TrainingEvaluationQuestions::where('training_id', $training->id)
                ->where('type', 'scale')
                ->pluck('id');

            $scaleAnswers = TrainingEvaluationUsersAnswers::whereIn('teq_id', $scaleQuestionIds)
                ->get()
                ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100);

            $grouped = $scaleAnswers->groupBy('users_id');
            $userAverages = $grouped->map(fn($answers) => $answers->avg('answers'));
            $overallAvg = $userAverages->avg() ?? 0;
            $converted = ($overallAvg / 100) * 5;
            $training->average_evaluation = round(min($converted, 5), 1);

            // Pre-Test
            $preTestScores = DB::table('pre_test_users_answers as ua')
                ->join('pre_test_answers as a', function ($join) {
                    $join->on('ua.pre_test_questions_id', '=', 'a.pre_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->whereIn('ua.pre_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('pre_test_questions')
                        ->where('training_id', $training->id);
                })
                ->select('ua.users_id', DB::raw('AVG(a.is_correct) as score'))
                ->groupBy('ua.users_id')
                ->get();

            $training->average_pretest = ($preTestScores->avg('score') ?? 0) * 100;

            // Post-Test
            $postTestScores = DB::table('post_test_users_answers as ua')
                ->join('post_test_answers as a', function ($join) {
                    $join->on('ua.post_test_questions_id', '=', 'a.post_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->whereIn('ua.post_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('post_test_questions')
                        ->where('training_id', $training->id);
                })
                ->select('ua.users_id', DB::raw('AVG(a.is_correct) as score'))
                ->groupBy('ua.users_id')
                ->get();

            $training->average_posttest = ($postTestScores->avg('score') ?? 0) * 100;

            return $training;
        });

        // Buat pilihan tahun dari data training
        $years = Training::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->pluck('year');

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('internal.report.training-evaluation-report.index', [
            'trainings' => $trainings,
            'years' => $years,
            'months' => $months,
        ]);
    }

    public function print(Request $request)
    {
        $query = Training::with('category')
            ->withCount('participants');

        // Filter berdasarkan tahun dan bulan (start_date)
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        // Ambil data sebagai Collection
        $trainings = $query->get()->map(function ($training) {
            // Evaluasi Skala
            $scaleQuestionIds = TrainingEvaluationQuestions::where('training_id', $training->id)
                ->where('type', 'scale')
                ->pluck('id');

            $scaleAnswers = TrainingEvaluationUsersAnswers::whereIn('teq_id', $scaleQuestionIds)
                ->get()
                ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100);

            $grouped = $scaleAnswers->groupBy('users_id');
            $userAverages = $grouped->map(fn($answers) => $answers->avg('answers'));
            $overallAvg = $userAverages->avg() ?? 0;
            $converted = ($overallAvg / 100) * 5;
            $training->average_evaluation = round(min($converted, 5), 1);

            // Pre-Test
            $preTestScores = DB::table('pre_test_users_answers as ua')
                ->join('pre_test_answers as a', function ($join) {
                    $join->on('ua.pre_test_questions_id', '=', 'a.pre_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->whereIn('ua.pre_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('pre_test_questions')
                        ->where('training_id', $training->id);
                })
                ->select('ua.users_id', DB::raw('AVG(a.is_correct) as score'))
                ->groupBy('ua.users_id')
                ->get();

            $training->average_pretest = ($preTestScores->avg('score') ?? 0) * 100;

            // Post-Test
            $postTestScores = DB::table('post_test_users_answers as ua')
                ->join('post_test_answers as a', function ($join) {
                    $join->on('ua.post_test_questions_id', '=', 'a.post_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->whereIn('ua.post_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('post_test_questions')
                        ->where('training_id', $training->id);
                })
                ->select('ua.users_id', DB::raw('AVG(a.is_correct) as score'))
                ->groupBy('ua.users_id')
                ->get();

            $training->average_posttest = ($postTestScores->avg('score') ?? 0) * 100;

            return $training;
        });

        // Buat pilihan tahun dari data training
        $years = Training::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->pluck('year');

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $pdf = Pdf::loadView('internal.report.training-evaluation-report.print', [
            'trainings' => $trainings,
            'years' => $years,
            'months' => $months,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-evaluasi-pelatihan.pdf');
    }
}
