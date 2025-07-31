<?php

namespace App\Http\Controllers\Internal\Home;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Training;
use Illuminate\Support\Facades\DB;
use App\Models\PreTestAnswers;
use App\Models\PostTestAnswers;
use App\Models\TrainingUser;
use App\Models\PreTestUsersAnswers;
use App\Models\PostTestUsersAnswers;
use App\Models\TrainingEvaluationUsersAnswers;
use App\Models\InstructorEvaluationUsersAnswers;
use App\Models\User;
use App\Models\Learning;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTrainings = Training::count();
        $totalParticipants = User::where('role', 'user')->count();
        $totalVideos = Learning::count();
        $totalAssistances = Assistance::count();

        // Ambil data pendaftar pelatihan
        $trainingRegistrations = DB::table('training_users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Ambil data pendaftar pendampingan
        $assistanceRegistrations = DB::table('assistance_users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // Gabungkan tanggal-tanggal dari kedua sumber
        $allDates = $trainingRegistrations->keys()->merge($assistanceRegistrations->keys())->unique()->sort();

        // Gabungkan data berdasarkan tanggal
        $combinedData = $allDates->map(function ($date) use ($trainingRegistrations, $assistanceRegistrations) {
            return [
                'date' => $date,
                'training' => $trainingRegistrations[$date]->total ?? 0,
                'assistance' => $assistanceRegistrations[$date]->total ?? 0,
            ];
        });

        $trainingRegistrationData = [
            'labels' => $combinedData->pluck('date'),
            'training' => $combinedData->pluck('training'),
            'assistance' => $combinedData->pluck('assistance'),
        ];

        // Pre-Test Statistics
        $preTestScores = PreTestUsersAnswers::all()
            ->groupBy('users_id')
            ->map(function ($answers) {
                $correct = 0;
                foreach ($answers as $answer) {
                    $isCorrect = PreTestAnswers::where('pre_test_questions_id', $answer->pre_test_questions_id)
                        ->where('answer', $answer->answer)
                        ->where('is_correct', true)
                        ->exists();
                    if ($isCorrect) $correct++;
                }
                $total = $answers->count();
                return $total > 0 ? round(($correct / $total) * 100, 2) : 0;
            });

        $preTestData = [
            'labels' => $preTestScores->keys(), // user_id
            'data' => $preTestScores->values()
        ];


        // Post-Test Statistics
        $postTestScores = PostTestUsersAnswers::all()
            ->groupBy('users_id')
            ->map(function ($answers) {
                $correct = 0;
                foreach ($answers as $answer) {
                    $isCorrect = PostTestAnswers::where('post_test_questions_id', $answer->post_test_questions_id)
                        ->where('answer', $answer->answer)
                        ->where('is_correct', true)
                        ->exists();
                    if ($isCorrect) $correct++;
                }
                $total = $answers->count();
                return $total > 0 ? round(($correct / $total) * 100, 2) : 0;
            });

        $postTestData = [
            'labels' => $postTestScores->keys(), // user_id
            'data' => $postTestScores->values()
        ];


        // Training Evaluation Statistics
        $trainingEvaluationAnswers = TrainingEvaluationUsersAnswers::all();
        $trainingEvaluationData = $trainingEvaluationAnswers
            ->filter(fn(TrainingEvaluationUsersAnswers $a) => is_numeric($a->answers) && $a->answers <= 100)
            ->groupBy('answers')
            ->map->count();

        // Instructor Evaluation Statistics
        $instructorEvaluationAnswers = InstructorEvaluationUsersAnswers::all();
        $instructorEvaluationData = $instructorEvaluationAnswers
            ->filter(fn(InstructorEvaluationUsersAnswers $a) => is_numeric($a->answers) && $a->answers <= 100)
            ->groupBy('answers')
            ->map->count();

        return view('internal.home.dashboard.index', compact(
            'trainingRegistrationData',
            'preTestData',
            'postTestData',
            'trainingEvaluationData',
            'instructorEvaluationData'
        ), [
            'totalTrainings' => $totalTrainings,
            'totalParticipants' => $totalParticipants,
            'totalVideos' => $totalVideos,
            'totalAssistances' => $totalAssistances,
        ]);
    }
}
