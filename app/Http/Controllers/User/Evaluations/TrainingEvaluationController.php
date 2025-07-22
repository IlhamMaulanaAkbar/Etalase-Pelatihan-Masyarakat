<?php

namespace App\Http\Controllers\User\Evaluations;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingEvaluationUsersAnswers;
use App\Models\TrainingEvaluationQuestions;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingUser;
use Illuminate\Http\Request;

class TrainingEvaluationController extends Controller
{
    public function convertScaleToFixed($scale)
    {
        $map = [
            1 => 20,
            2 => 40,
            3 => 60,
            4 => 80,
            5 => 100,
        ];

        return $map[$scale] ?? 0;
    }
    public function start(Training $training)
    {
        $user = Auth::guard('user')->user();

        $alreadyEvaluated = TrainingEvaluationUsersAnswers::where('users_id', $user->id)
            ->whereIn('teq_id', function ($query) use ($training) {
                $query->select('id')->from('training_evaluation_questions')->where('training_id', $training->id);
            })->exists();


        return view('public.evaluations.training-evaluation.start', compact('training'));
    }

    public function ongoing(Training $training)
    {
        $user = Auth::guard('user')->user();

        $questions = TrainingEvaluationQuestions::with('answers')
            ->where('training_id', $training->id)
            ->get();

        $alreadyEvaluated = TrainingEvaluationUsersAnswers::where('users_id', $user->id)
            ->whereIn('teq_id', $questions->pluck('id'))
            ->exists();

        if ($alreadyEvaluated) {
            return redirect()->route('public.account.profile.index')->with('error', 'Anda sudah mengerjakan evaluasi untuk pelatihan ini.');
        }

        $trainingUser = TrainingUser::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        if ($trainingUser && !$trainingUser->started_training_evaluation) {
            $trainingUser->started_training_evaluation = true;
            $trainingUser->save();
        }

        return view('public.evaluations.training-evaluation.ongoing', compact('training', 'questions'));
    }

    public function submit(Request $request, Training $training)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $request->input('answers', []);

        foreach ($answers as $questionId => $answer) {
            $question = TrainingEvaluationQuestions::find($questionId);

            if ($question) {
                // Jika tipe skala, konversi nilai 1–5 ke 20–100
                if ($question->type === 'scale') {
                    $fixed = $this->convertScaleToFixed((int) $answer); // <<=== di sinilah kamu tambahkan
                    TrainingEvaluationUsersAnswers::create([
                        'teq_id' => $questionId,
                        'users_id' => $user->id,
                        'answers' => $fixed, // <<=== simpan nilai tetap (20–100)
                    ]);
                } else {
                    // Tipe text langsung simpan
                    TrainingEvaluationUsersAnswers::create([
                        'teq_id' => $questionId,
                        'users_id' => $user->id,
                        'answers' => $answer,
                    ]);
                }
            }
        }

        return view('public.evaluations.training-evaluation.finish', [
            'training' => $training,
        ]);
    }
}
