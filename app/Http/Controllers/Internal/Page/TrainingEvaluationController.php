<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\TrainingEvaluationUsersAnswers;
use App\Models\TrainingEvaluationQuestions;
use App\Models\PreTestUsersAnswers;
use App\Models\PostTestUsersAnswers;
use App\Models\Training;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TrainingEvaluationController extends Controller
{

    public function index()
    {
        $trainings = Training::with('category')
            ->withCount('participants')
            ->get()
            ->map(function ($training) {
                // Ambil semua pertanyaan evaluasi tipe skala untuk pelatihan ini
                $scaleQuestionIds = TrainingEvaluationQuestions::where('training_id', $training->id)
                    ->where('type', 'scale')
                    ->pluck('id');

                // Ambil semua jawaban evaluasi pengguna untuk pelatihan ini
                $scaleAnswers = TrainingEvaluationUsersAnswers::whereIn('teq_id', $scaleQuestionIds)
                    ->get()
                    ->filter(fn($a) => is_numeric($a->answers) && $a->answers <= 100);

                // Kelompokkan berdasarkan user_id
                $grouped = $scaleAnswers->groupBy('users_id');

                // Hitung rata-rata per user
                $userAverages = $grouped->map(function ($answers) {
                    return $answers->avg('answers');
                });

                // Hitung rata-rata semua peserta
                $overallAvg = $userAverages->avg() ?? 0;

                // Konversi ke skala 5 (opsional)
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

        return view('internal.evaluations.training-evaluation.response.index', compact('trainings'));
    }


    public function show($id)
    {
        $training = Training::with('category', 'participants')->findOrFail($id);

        // Ambil semua peserta pelatihan
        $participants = $training->participant()->get();

        // Ambil semua pertanyaan evaluasi bertipe skala
        $scaleQuestionIds = TrainingEvaluationQuestions::where('training_id', $training->id)
            ->where('type', 'scale')
            ->pluck('id');

        // Loop peserta untuk hitung nilai
        $participantsWithScores = $participants->map(function ($user) use ($training, $scaleQuestionIds) {
            // Pre-test
            $preTestScore = DB::table('pre_test_users_answers as ua')
                ->join('pre_test_answers as a', function ($join) {
                    $join->on('ua.pre_test_questions_id', '=', 'a.pre_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->where('ua.users_id', $user->id)
                ->whereIn('ua.pre_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('pre_test_questions')
                        ->where('training_id', $training->id);
                })
                ->avg('a.is_correct');

            // Post-test
            $postTestScore = DB::table('post_test_users_answers as ua')
                ->join('post_test_answers as a', function ($join) {
                    $join->on('ua.post_test_questions_id', '=', 'a.post_test_questions_id')
                        ->on('ua.answer', '=', 'a.answer');
                })
                ->where('ua.users_id', $user->id)
                ->whereIn('ua.post_test_questions_id', function ($query) use ($training) {
                    $query->select('id')
                        ->from('post_test_questions')
                        ->where('training_id', $training->id);
                })
                ->avg('a.is_correct');

            // Evaluasi skala
            $scaleAnswers = TrainingEvaluationUsersAnswers::whereIn('teq_id', $scaleQuestionIds)
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
                'pre_test' => $preTestScore ? round($preTestScore * 100) : 0,
                'post_test' => $postTestScore ? round($postTestScore * 100) : 0,
                'evaluation' => round(min($converted, 5), 1),
            ];
        });

        return view('internal.evaluations.training-evaluation.response.show', compact('training', 'participantsWithScores'));
    }
}
