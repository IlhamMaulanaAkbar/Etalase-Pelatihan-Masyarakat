<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
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
        // Logic to show a specific instructor evaluation
        return view('internal.evaluations.instructor-evaluation.response.show', compact('id'));
    }
}
