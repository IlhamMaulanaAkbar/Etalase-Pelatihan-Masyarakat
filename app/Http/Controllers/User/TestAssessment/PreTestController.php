<?php

namespace App\Http\Controllers\User\TestAssessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\PreTestQuestions;
use App\Models\PreTestUsersAnswers;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingUser;
use App\Models\User;

class PreTestController extends Controller
{
    /**
     * Menampilkan panduan pre-test sebelum mulai.
     */
    public function start(Training $training)
    {
        $user = Auth::guard('user')->user();

        // Cek apakah user sudah mengerjakan pre-test
        $alreadyAnswered = PreTestUsersAnswers::where('users_id', $user->id)
            ->whereIn('pre_test_questions_id', function ($query) use ($training) {
                $query->select('id')->from('pre_test_questions')->where('training_id', $training->id);
            })->exists();

        if ($alreadyAnswered) {
            return redirect()->back()->with('error', 'Anda sudah mengerjakan pre-test untuk pelatihan ini.');
        }

        return view('public.test-assessment.pre-test.start', compact('training'));
    }

    public function ongoing(Training $training)
    {
        $user = Auth::guard('user')->user();

        // Ambil pertanyaan dan jawaban
        $questions = PreTestQuestions::with('answers')
            ->where('training_id', $training->id)
            ->get();

        // Jika user sudah pernah menjawab, arahkan ke profil
        $alreadyAnswered = PreTestUsersAnswers::where('users_id', $user->id)
            ->whereIn('pre_test_questions_id', $questions->pluck('id'))
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('public.account.profile.index')->with('error', 'Anda sudah mengerjakan pre-test untuk pelatihan ini.');
        }

        $trainingUser = TrainingUser::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        if ($trainingUser && !$trainingUser->started_pretest) {
            $trainingUser->started_pretest = true;
            $trainingUser->save();
        }

        return view('public.test-assessment.pre-test.ongoing', compact('training', 'questions'));
    }

    public function submit(Request $request, Training $training)
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Session habis, silakan login kembali.');
        }

        $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:255',
        ]);

        $answers = $request->input('answers', []);

        if (count($answers) > 0) {
            foreach ($answers as $question_id => $answer) {
                PreTestUsersAnswers::create([
                    'pre_test_questions_id' => $question_id,
                    'users_id' => $user->id,
                    'answer' => $answer,
                ]);
            }
        }

        return view('public.test-assessment.pre-test.finish', [
            'training' => $training,
        ]);
    }
}
