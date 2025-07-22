<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingUser;
use App\Services\Supports\Alert;
use App\Models\PreTestUsersAnswers;
use App\Models\PreTestAnswers;
use App\Models\PostTestUsersAnswers;
use App\Models\PostTestAnswers;

class TrainingParticipantController extends Controller
{
    public function index()
    {
        $trainings = Training::withCount('training_users')->get()->sortByDesc('created_at');
        return view('internal.participants.index', compact('trainings'));
    }

    public function show(Training $training)
    {
        $participants = $training->training_users()->with('user')->get();

        $preTestQuestionIds = $training->preTestQuestions->pluck('id');
        $postTestQuestionsIds = $training->postTestQuestions->pluck('id');

        foreach ($participants as $participant) {
            // PRE-TEST
            $userPreAnswers = PreTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('pre_test_questions_id', $preTestQuestionIds)
                ->whereNotNull('answer') // hanya yang menjawab
                ->get();

            if ($userPreAnswers->count() > 0) {
                $correct = 0;
                foreach ($userPreAnswers as $answer) {
                    $isCorrect = PreTestAnswers::where('pre_test_questions_id', $answer->pre_test_questions_id)
                        ->where('answer', $answer->answer)
                        ->where('is_correct', true)
                        ->exists();

                    if ($isCorrect) {
                        $correct++;
                    }
                }

                $totalQuestions = count($preTestQuestionIds);
                $participant->pre_test_score = $totalQuestions > 0
                    ? round(($correct / $totalQuestions) * 100)
                    : null;
            } else {
                $participant->pre_test_score = null; // belum mengerjakan
            }

            // POST-TEST
            $userPostAnswers = PostTestUsersAnswers::where('users_id', $participant->user_id)
                ->whereIn('post_test_questions_id', $postTestQuestionsIds)
                ->whereNotNull('answer') // hanya yang menjawab
                ->get();

            if ($userPostAnswers->count() > 0) {
                $correct = 0;
                foreach ($userPostAnswers as $answer) {
                    $isCorrect = PostTestAnswers::where('post_test_questions_id', $answer->post_test_questions_id)
                        ->where('answer', $answer->answer)
                        ->where('is_correct', true)
                        ->exists();

                    if ($isCorrect) {
                        $correct++;
                    }
                }

                $totalPostQuestions = count($postTestQuestionsIds);
                $participant->post_test_score = $totalPostQuestions > 0
                    ? round(($correct / $totalPostQuestions) * 100)
                    : null;
            } else {
                $participant->post_test_score = null; // belum mengerjakan
            }
        }

        return view('internal.participants.show', compact('training', 'participants'));
    }


    public function status(Request $request, TrainingUser $training_user)
    {
        if ($training_user->status !== 'DAFTAR') {
            return back()->with(Alert::error('Status tidak dapat diubah karena sudah diproses.'));
        }
        $request->validate([
            'status' => 'required|in:LULUS,TIDAK_LULUS',
        ]);

        $training_user->status = $request->status;
        $training_user->is_approved = $request->status === 'LULUS';

        // Set verified_at hanya jika status diubah menjadi LULUS dan belum pernah diverifikasi
        if ($request->status === 'LULUS' && !$training_user->verified_at) {
            $training_user->verified_at = now();
        }
        $training_user->save();

        return back()->with(Alert::success('Status peserta berhasil diperbarui.'));
    }
}
