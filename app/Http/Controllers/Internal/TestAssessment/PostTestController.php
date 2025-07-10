<?php

namespace App\Http\Controllers\Internal\TestAssessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostTestQuestions;
use App\Models\PostTestAnswers;
use App\Models\PostTestUsersAnswers;
use App\Models\Training;
use App\Services\Supports\Alert;

class PostTestController extends Controller
{
    public function index(Training $training)
    {
        $questions = PostTestQuestions::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('internal.test-assessment.post-test.index', compact('training', 'questions'));
    }

    public function create(Training $training)
    {
        return view('internal.test-assessment.post-test.create', compact('training'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|size:4',
            'correct_answer' => 'required|in:0,1,2,3',
        ]);

        // Simpan pertanyaan
        $question = PostTestQuestions::create([
            'training_id' => $request->training_id,
            'question' => $request->question,
        ]);

        // Simpan semua jawaban
        foreach ($request->answers as $index => $answer) {
            PostTestAnswers::create([
                'post_test_questions_id' => $question->id,
                'answer' => $answer['text'],
                'is_correct' => $request->correct_answer == $index,
            ]);
        }

        return redirect()->route('internal.test-assessment.post-test.index', [
            'training' => $request->training_id
        ])->with(Alert::success('Pertanyaan berhasil disimpan.'));
    }

    public function edit(Training $training, PostTestQuestions $post_test)
    {
        $question = $post_test->load('answers');
        return view('internal.test-assessment.post-test.edit', compact('training', 'question'));
    }

    public function update(Request $request, Training $training, PostTestQuestions $post_test)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|size:4',
            'correct_answer' => 'required|in:0,1,2,3',
        ]);

        // Update pertanyaan
        $post_test->update([
            'question' => $request->question,
        ]);

        // Hapus jawaban lama
        PostTestAnswers::where('post_test_questions_id', $post_test->id)->delete();

        // Simpan jawaban baru
        foreach ($request->answers as $index => $answer) {
            PostTestAnswers::create([
                'post_test_questions_id' => $post_test->id,
                'answer' => $answer['text'],
                'is_correct' => $request->correct_answer == $index,
            ]);
        }

        return redirect()->route('internal.test-assessment.post-test.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan berhasil diperbarui.'));
    }

    public function destroy(Training $training, PostTestQuestions $post_test)
    {
        // Hapus pertanyaan dan semua jawaban terkait
        $post_test->delete();

        return redirect()->route('internal.test-assessment.post-test.index', [
            'training' => $training->id,
        ])->with(Alert::success('Pertanyaan berhasil dihapus.'));
    }
}
