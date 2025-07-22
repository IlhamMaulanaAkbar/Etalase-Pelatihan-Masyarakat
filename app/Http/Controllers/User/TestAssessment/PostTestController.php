<?php

namespace App\Http\Controllers\User\TestAssessment;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;
use App\Models\PostTestUsersAnswers;
use App\Models\PostTestQuestions;
use App\Models\TrainingUser;
use Illuminate\Http\Request;

class PostTestController extends Controller
{
    public function start(Training $training)
    {
        $user = Auth::guard('user')->user();

        $alreadyAnswered = PostTestUsersAnswers::where('users_id', $user->id)
            ->whereIn('post_test_questions_id', function ($query) use ($training) {
                $query->select('id')->from('post_test_questions')->where('training_id', $training->id);
            })->exists();

        if ($alreadyAnswered) {
            return redirect()->back()->with('error', 'Anda sudah mengerjakan post-test untuk pelatihan ini.');
        }
        return view('public.test-assessment.post-test.start', compact('training'));
    }

    public function ongoing(Training $training)
    {
        $user = Auth::guard('user')->user();

        $questions = PostTestQuestions::with('answers')
            ->where('training_id', $training->id)
            ->get();

        $alreadyAnswered = PostTestUsersAnswers::where('users_id', $user->id)
            ->whereIn('post_test_questions_id', $questions->pluck('id'))
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('public.account.profile.index')->with('error', 'Anda sudah mengerjakan post-test untuk pelatihan ini.');
        }

        $trainingUser = TrainingUser::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->first();

        if ($trainingUser && !$trainingUser->started_posttest) {
            $trainingUser->started_posttest = true;
            $trainingUser->save();
        }

        return view('public.test-assessment.post-test.ongoing', compact('questions', 'training'));
    }

    public function submit(Request $request, Training $training)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string',
        ]);

        $answers = $request->input('answers', []);

        if (count($answers) > 0) {
            foreach ($answers as $question_id => $answer) {
                PostTestUsersAnswers::create([
                    'post_test_questions_id' => $question_id,
                    'users_id' => $user->id,
                    'answer' => $answer,
                ]);
            }
        }

        return view('public.test-assessment.post-test.finish', [
            'training' => $training,
        ]);
    }
}
