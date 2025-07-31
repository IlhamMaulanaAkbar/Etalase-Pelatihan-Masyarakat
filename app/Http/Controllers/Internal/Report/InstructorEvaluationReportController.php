<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\InstructorEvaluationQuestions;
use App\Models\InstructorEvaluationUsersAnswers;
use Barryvdh\DomPDF\Facade\Pdf;

class InstructorEvaluationReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::with('category')
            ->withCount('participants');

        // Apply filters based on request parameters if needed
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $trainings = $query->get()
            ->map(function ($training) {
                $scaleQuestionIds = InstructorEvaluationQuestions::where('training_id', $training->id)
                    ->where('type', 'scale')
                    ->pluck('id');

                $scaleAnswers = InstructorEvaluationUsersAnswers::whereIn('ieq_id', $scaleQuestionIds)
                    ->get()
                    ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100);

                $grouped = $scaleAnswers->groupBy('users_id');

                $userAverages = $grouped->map(function ($answers) {
                    return $answers->avg('answers');
                });

                $overallAvg = $userAverages->avg() ?? 0;

                $converted = ($overallAvg / 100) * 5;

                $training->average_evaluation = round(min($converted, 5), 1);

                return $training;
            });

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

        return view('internal.report.instructor-evaluation-report.index', [
            'trainings' => $trainings,
            'years' => $years,
            'months' => $months,
        ]);
    }

    public function print(Request $request)
    {
        $query = Training::with('category')
            ->withCount('participants');

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $trainings = $query->get()
            ->map(function ($training) {
                $scaleQuestionIds = InstructorEvaluationQuestions::where('training_id', $training->id)
                    ->where('type', 'scale')
                    ->pluck('id');

                $scaleAnswers = InstructorEvaluationUsersAnswers::whereIn('ieq_id', $scaleQuestionIds)
                    ->get()
                    ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100);

                $grouped = $scaleAnswers->groupBy('users_id');

                $userAverages = $grouped->map(fn($answers) => $answers->avg('answers'));
                $overallAvg = $userAverages->avg() ?? 0;
                $converted = ($overallAvg / 100) * 5;
                $training->average_evaluation = round(min($converted, 5), 1);

                return $training;
            });

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

        $pdf = Pdf::loadView('internal.report.instructor-evaluation-report.print', [
            'trainings' => $trainings,
            'years' => $years,
            'months' => $months,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-evaluasi-instruktur-pelatihan.pdf');
    }
}
