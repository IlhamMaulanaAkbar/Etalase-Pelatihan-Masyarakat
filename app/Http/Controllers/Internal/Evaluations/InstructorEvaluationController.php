<?php

namespace App\Http\Controllers\Internal\Evaluations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstructorEvaluationQuestions;
use App\Models\InstructorEvaluationAnswers;
use App\Models\Training;
use App\Services\Supports\Alert;

class InstructorEvaluationController extends Controller
{
    public function index(Training $training)
    {
        $questions = InstructorEvaluationQuestions::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('internal.evaluations.instructor-evaluation.index', compact('training', 'questions'));
    }

    public function create(Training $training)
    {
        return view('internal.evaluations.instructor-evaluation.create', compact('training'));
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
        $question = InstructorEvaluationQuestions::create([
            'training_id' => $training->id,
            'question' => $request->question,
            'type' => $request->type,
        ]);

        // Save all answers
        if ($request->type === 'scale' && $request->filled('answers')) {
            foreach ($request->answers as $answer) {
                InstructorEvaluationAnswers::create([
                    'ieq_id' => $question->id,
                    'answers' => $answer,
                ]);
            }
        }

        return redirect()->route('internal.evaluations.instructor-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil disimpan.'));
    }

    public function edit(Training $training, InstructorEvaluationQuestions $instructor_evaluation)
    {
        $question = $instructor_evaluation->load('answers');
        $answers = $question->answers;

        return view('internal.evaluations.instructor-evaluation.edit', compact('training', 'question', 'answers'));
    }

    public function update(Request $request, Training $training, InstructorEvaluationQuestions $instructor_evaluation)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'type' => 'required|in:scale,text',
            'answers' => $request->type === 'scale' ? 'required|array' : 'nullable|array',
            'answers.*' => $request->type === 'scale' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        // Update the evaluation question
        $instructor_evaluation->update([
            'question' => $request->question,
            'type' => $request->type,
        ]);

        InstructorEvaluationAnswers::where('ieq_id', $instructor_evaluation->id)->delete();

        // Update all answers
        if ($request->type === 'scale' && $request->filled('answers')) {
            foreach ($request->answers as $answer) {
                InstructorEvaluationAnswers::create([
                    'ieq_id' => $instructor_evaluation->id,
                    'answers' => $answer,
                ]);
            }
        }

        return redirect()->route('internal.evaluations.instructor-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil diperbarui.'));
    }

    public function destroy(Training $training, InstructorEvaluationQuestions $instructor_evaluation)
    {
        $instructor_evaluation->delete();
        return redirect()->route('internal.evaluations.instructor-evaluation.index', [
            'training' => $training->id
        ])->with(Alert::success('Pertanyaan evaluasi berhasil dihapus.'));
    }
}
