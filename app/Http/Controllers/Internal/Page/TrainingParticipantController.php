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
use App\Mail\TrainingAcceptedMail;
use Illuminate\Support\Facades\Mail;

class TrainingParticipantController extends Controller
{
    public function index()
    {
        $trainings = Training::withCount('training_users')->get()->sortByDesc('created_at');
        return view('internal.participants.training.index', compact('trainings'));
    }

    public function show(Training $training)
    {
        $participants = $training->training_users()->with('user')->get();

        $preTestQuestions = $training->preTestQuestions()->with('answers')->get();
        $postTestQuestions = $training->postTestQuestions()->with('answers')->get();
        $preTestQuestionIds = $preTestQuestions->pluck('id');
        $postTestQuestionsIds = $postTestQuestions->pluck('id');

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

            $participant->pre_test_detail = $this->buildPreTestDetail(
                $preTestQuestions,
                $participant->user_id
            );
            $participant->post_test_detail = $this->buildPostTestDetail(
                $postTestQuestions,
                $participant->user_id
            );
        }

        return view('internal.participants.training.show', compact('training', 'participants'));
    }

    private function buildPreTestDetail($questions, int $userId): array
    {
        $userAnswers = PreTestUsersAnswers::where('users_id', $userId)
            ->whereIn('pre_test_questions_id', $questions->pluck('id'))
            ->get()
            ->keyBy('pre_test_questions_id');

        return $this->buildAssessmentDetail($questions, $userAnswers);
    }

    private function buildPostTestDetail($questions, int $userId): array
    {
        $userAnswers = PostTestUsersAnswers::where('users_id', $userId)
            ->whereIn('post_test_questions_id', $questions->pluck('id'))
            ->get()
            ->keyBy('post_test_questions_id');

        return $this->buildAssessmentDetail($questions, $userAnswers);
    }

    private function buildAssessmentDetail($questions, $userAnswers): array
    {
        $items = $questions->map(function ($question) use ($userAnswers) {
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            $userAnswer = $userAnswers->get($question->id);
            $isAnswered = $userAnswer && $userAnswer->answer !== null;
            $isCorrect = $isAnswered && $correctAnswer && $userAnswer->answer === $correctAnswer->answer;

            return [
                'question' => $question->question,
                'correct_answer' => $correctAnswer?->answer,
                'user_answer' => $userAnswer?->answer,
                'is_answered' => $isAnswered,
                'is_correct' => $isCorrect,
            ];
        });

        return [
            'total' => $items->count(),
            'correct' => $items->where('is_correct', true)->count(),
            'wrong' => $items->where('is_answered', true)->where('is_correct', false)->count(),
            'unanswered' => $items->where('is_answered', false)->count(),
            'items' => $items,
        ];
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

        if ($request->status === 'LULUS') {
            $training_user->loadMissing(['user', 'training']);

            if ($training_user->user && $training_user->user->email) {
                Mail::to($training_user->user->email)->queue(
                    new TrainingAcceptedMail(
                        $training_user->user,
                        $training_user->training,
                        $training_user->registration_number
                    )
                );
            }
        }

        return back()->with(Alert::success('Status peserta berhasil diperbarui.'));
    }
}
