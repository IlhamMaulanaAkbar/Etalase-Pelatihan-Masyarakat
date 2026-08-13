<?php

namespace App\Http\Controllers\Internal\Templates;

use App\Http\Controllers\Controller;
use App\Models\AssessmentTemplateAnswer;
use App\Models\AssessmentTemplateQuestion;
use App\Models\Category;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssessmentTemplateController extends Controller
{
    private array $types = [
        'pre-test' => [
            'value' => 'pre_test',
            'title' => 'Template Pre Test',
            'answer_mode' => 'choice',
        ],
        'post-test' => [
            'value' => 'post_test',
            'title' => 'Template Post Test',
            'answer_mode' => 'choice',
        ],
        'training-evaluation' => [
            'value' => 'training_evaluation',
            'title' => 'Template Evaluasi Pelatihan',
            'answer_mode' => 'evaluation',
        ],
        'instructor-evaluation' => [
            'value' => 'instructor_evaluation',
            'title' => 'Template Evaluasi Instruktur',
            'answer_mode' => 'evaluation',
        ],
    ];

    public function index(Request $request, string $templateType)
    {
        $meta = $this->meta($templateType);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $categoryId = $request->query('category_id');

        $questions = AssessmentTemplateQuestion::with(['category', 'answers'])
            ->where('template_type', $meta['value'])
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('internal.templates.assessments.index', compact(
            'templateType',
            'meta',
            'categories',
            'categoryId',
            'questions'
        ));
    }

    public function create(Request $request, string $templateType)
    {
        $meta = $this->meta($templateType);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $selectedCategoryId = $request->query('category_id');

        return view('internal.templates.assessments.create', compact(
            'templateType',
            'meta',
            'categories',
            'selectedCategoryId'
        ));
    }

    public function store(Request $request, string $templateType)
    {
        $meta = $this->meta($templateType);
        $validated = $this->validatedData($request, $meta);

        $question = AssessmentTemplateQuestion::create([
            'category_id' => $validated['category_id'],
            'template_type' => $meta['value'],
            'question' => $validated['question'],
            'question_type' => $meta['answer_mode'] === 'evaluation' ? $validated['question_type'] : null,
        ]);

        $this->syncAnswers($question, $request, $meta);

        return redirect()
            ->route('internal.templates.assessments.index', [
                'templateType' => $templateType,
                'category_id' => $question->category_id,
            ])
            ->with(Alert::success('Template pertanyaan berhasil disimpan.'));
    }

    public function edit(string $templateType, AssessmentTemplateQuestion $question)
    {
        $meta = $this->meta($templateType);
        abort_if($question->template_type !== $meta['value'], 404);

        $question->load('answers');
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        return view('internal.templates.assessments.edit', compact(
            'templateType',
            'meta',
            'categories',
            'question'
        ));
    }

    public function update(Request $request, string $templateType, AssessmentTemplateQuestion $question)
    {
        $meta = $this->meta($templateType);
        abort_if($question->template_type !== $meta['value'], 404);

        $validated = $this->validatedData($request, $meta);

        $question->update([
            'category_id' => $validated['category_id'],
            'question' => $validated['question'],
            'question_type' => $meta['answer_mode'] === 'evaluation' ? $validated['question_type'] : null,
        ]);

        $this->syncAnswers($question, $request, $meta);

        return redirect()
            ->route('internal.templates.assessments.index', [
                'templateType' => $templateType,
                'category_id' => $question->category_id,
            ])
            ->with(Alert::success('Template pertanyaan berhasil diperbarui.'));
    }

    public function destroy(string $templateType, AssessmentTemplateQuestion $question)
    {
        $meta = $this->meta($templateType);
        abort_if($question->template_type !== $meta['value'], 404);

        $categoryId = $question->category_id;
        $question->delete();

        return redirect()
            ->route('internal.templates.assessments.index', [
                'templateType' => $templateType,
                'category_id' => $categoryId,
            ])
            ->with(Alert::success('Template pertanyaan berhasil dihapus.'));
    }

    private function meta(string $templateType): array
    {
        abort_unless(array_key_exists($templateType, $this->types), 404);

        return $this->types[$templateType];
    }

    private function validatedData(Request $request, array $meta): array
    {
        $rules = [
            'category_id' => ['required', 'exists:category,id'],
            'question' => ['required', 'string', 'max:255'],
        ];

        if ($meta['answer_mode'] === 'choice') {
            $rules['answers'] = ['required', 'array', 'size:4'];
            $rules['answers.*.text'] = ['required', 'string', 'max:255'];
            $rules['correct_answer'] = ['required', Rule::in(['0', '1', '2', '3', 0, 1, 2, 3])];
        } else {
            $rules['question_type'] = ['required', Rule::in(['scale', 'text'])];
            $rules['answers'] = [$request->question_type === 'scale' ? 'required' : 'nullable', 'array'];
            $rules['answers.*'] = [$request->question_type === 'scale' ? 'required' : 'nullable', 'string', 'max:255'];
        }

        return $request->validate($rules);
    }

    private function syncAnswers(AssessmentTemplateQuestion $question, Request $request, array $meta): void
    {
        AssessmentTemplateAnswer::where('assessment_template_question_id', $question->id)->delete();

        if ($meta['answer_mode'] === 'choice') {
            foreach ($request->answers as $index => $answer) {
                AssessmentTemplateAnswer::create([
                    'assessment_template_question_id' => $question->id,
                    'answer' => $answer['text'],
                    'is_correct' => (int) $request->correct_answer === $index,
                ]);
            }

            return;
        }

        if ($request->question_type === 'scale' && $request->filled('answers')) {
            foreach ($request->answers as $answer) {
                AssessmentTemplateAnswer::create([
                    'assessment_template_question_id' => $question->id,
                    'answer' => $answer,
                    'is_correct' => false,
                ]);
            }
        }
    }
}
