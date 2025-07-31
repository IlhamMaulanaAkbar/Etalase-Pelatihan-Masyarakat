<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Training;
use App\Models\InstructorEvaluationQuestions;
use App\Models\InstructorEvaluationUsersAnswers;
use Illuminate\Http\Request;

class InstructorEvaluationController extends Controller
{
    public function index()
    {
        $trainings = Training::with('category')
            ->withCount('participants')
            ->get()
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

        return view('internal.evaluations.instructor-evaluation.response.index', compact('trainings'));
    }

    public function show($id)
    {
        $training = Training::with('category', 'participant')->findOrFail($id);

        $participants = $training->participant()->get();

        $scaleQuestionIds = InstructorEvaluationQuestions::where('training_id', $training->id)
            ->where('type', 'scale')
            ->pluck('id');

        $participantsWithScores = $participants->map(function ($user) use ($training, $scaleQuestionIds) {
            $scaleAnswers = InstructorEvaluationUsersAnswers::whereIn('ieq_id', $scaleQuestionIds)
                ->where('users_id', $user->id)
                ->get();

            // Ambil nilai numerik, hanya yang <= 100
            $convertedValues = $scaleAnswers
                ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100)
                ->map(fn($a) => (int) $a->answers);

            $numericAvg = $convertedValues->avg() ?? 0;

            // Konversi ke skala 5 (jika masih dibutuhkan)
            $converted = ($numericAvg / 100) * 5;

            return (object)[
                'name' => $user->name,
                'scale_answers' => $scaleAnswers,
                'numeric_avg' => $numericAvg,
                'evaluation' => round(min($converted, 5), 1),
            ];
        });

        return view('internal.evaluations.instructor-evaluation.response.show', compact('training', 'participantsWithScores'));
    }
}
