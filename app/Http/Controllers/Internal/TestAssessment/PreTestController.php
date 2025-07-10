<?php

namespace App\Http\Controllers\Internal\TestAssessment;

use App\Http\Controllers\Controller;
use App\Models\PreTestAnswers;
use App\Models\PreTestQuestions;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Services\Supports\Alert;

class PreTestController extends Controller
{
    public function index(Training $training)
    {
        $questions = PreTestQuestions::where('training_id', $training->id)
            ->orderBy('created_at', 'desc') // urutkan berdasarkan tanggal dibuat
            ->paginate(5); // tampilkan 5 pertanyaan per halaman

        return view('internal.test-assessment.pre-test.index', compact('training', 'questions'));
    }


    public function create(Training $training)
    {
        return view('internal.test-assessment.pre-test.create', compact('training'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|size:4',
            'correct_answer' => 'required|in:0,1,2,3',
        ]);

        // Simpan pertanyaan
        $question = PreTestQuestions::create([
            'training_id' => $request->training_id, // ganti dengan dynamic training_id jika perlu
            'question' => $request->question,
        ]);

        // Simpan semua jawaban
        foreach ($request->answers as $index => $answer) {
            PreTestAnswers::create([
                'pre_test_questions_id' => $question->id,
                'answer' => $answer['text'],
                'is_correct' => $request->correct_answer == $index,
            ]);
        }

        return redirect()->route('internal.test-assessment.pre-test.index', [
            'training' => $request->training_id
        ])->with(Alert::success('Pertanyaan berhasil disimpan.'));
    }

    public function edit(Training $training, PreTestQuestions $pre_test)
    {
        $question = $pre_test->load('answers');
        return view('internal.test-assessment.pre-test.edit', compact('training', 'question'));
    }

    public function update(Request $request, Training $training, PreTestQuestions $pre_test)
    {

        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|size:4',
            'correct_answer' => 'required|in:0,1,2,3',
        ]);

        // Update pertanyaan
        $pre_test->update([
            'question' => $request->question,
        ]);

        // Hapus jawaban lama
        PreTestAnswers::where('pre_test_questions_id', $pre_test->id)->delete();

        // Simpan semua jawaban baru
        foreach ($request->answers as $index => $answer) {
            PreTestAnswers::create([
                'pre_test_questions_id' => $pre_test->id,
                'answer' => $answer['text'],
                'is_correct' => $request->correct_answer == $index,
            ]);
        }

        return redirect()->route('internal.test-assessment.pre-test.index', [
            'training' => $training->id,
        ])->with(Alert::success('Pertanyaan berhasil diperbarui.'));
    }

    public function destroy(Training $training, PreTestQuestions $pre_test)
    {
        // Hapus pertanyaan dan semua jawaban terkait
        $pre_test->delete();

        return redirect()->route('internal.test-assessment.pre-test.index', [
            'training' => $training->id,
        ])->with(Alert::success('Pertanyaan berhasil dihapus.'));
    }
}
