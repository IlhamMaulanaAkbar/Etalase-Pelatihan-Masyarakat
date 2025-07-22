<?php

namespace App\Http\Controllers\Internal\Evaluations;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingEvaluationQuestions;
use App\Models\TrainingEvaluationAnswers;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;

class TrainingEvaluationController extends Controller
{
    public function index(Training $training)
    {
        $questions = TrainingEvaluationQuestions::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('internal.evaluations.training-evaluation.index', compact('training', 'questions'));
    }

    public function create(Training $training)
    {
        return view('internal.evaluations.training-evaluation.create', compact('training'));
    }

    public function store(Request $request, Training $training)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'type' => 'required|in:scale,text',
            'answers' => $request->type === 'scale' ? 'required|array' : 'nullable|array',
            'answers.*' => $request->type === 'scale' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);


        // Save the evaluation question
        $question = TrainingEvaluationQuestions::create([
            'training_id' => $training->id,
            'question' => $request->question,
            'type' => $request->type,
        ]);

        // Save all answers
        if ($request->type === 'scale' && $request->filled('answers')) {
            foreach ($request->answers as $answer) {
                TrainingEvaluationAnswers::create([
                    'teq_id' => $question->id,
                    'answers' => $answer,
                ]);
            }
        }

        return redirect()->route('internal.evaluations.training-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil disimpan.'));
    }

    public function edit(Training $training, TrainingEvaluationQuestions $training_evaluation)
    {
        $question = $training_evaluation->load('answers');
        $answers = $question->answers;

        return view('internal.evaluations.training-evaluation.edit', compact('training', 'question', 'answers'));
    }

    public function update(Request $request, Training $training, TrainingEvaluationQuestions $training_evaluation)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'type' => 'required|in:scale,text',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:255',
        ]);

        // Update the evaluation question
        $training_evaluation->update([
            'question' => $request->question,
            'type' => $request->type,
        ]);

        TrainingEvaluationAnswers::where('teq_id', $training_evaluation->id)->delete();

        // Update all answers
        if ($request->type === 'scale' && $request->filled('answers')) {
            foreach ($request->answers as $answer) {
                TrainingEvaluationAnswers::create([
                    'teq_id' => $training_evaluation->id,
                    'answers' => $answer,
                ]);
            }
        }

        return redirect()->route('internal.evaluations.training-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil diperbarui.'));
    }

    public function destroy(Training $training, TrainingEvaluationQuestions $training_evaluation)
    {
        $training_evaluation->delete();

        return redirect()->route('internal.evaluations.training-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil dihapus.'));
    }
}
