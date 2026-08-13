<?php

namespace App\Services;

use App\Models\AssessmentTemplateQuestion;
use App\Models\InstructorEvaluationAnswers;
use App\Models\InstructorEvaluationQuestions;
use App\Models\PostTestAnswers;
use App\Models\PostTestQuestions;
use App\Models\PreTestAnswers;
use App\Models\PreTestQuestions;
use App\Models\Training;
use App\Models\TrainingEvaluationAnswers;
use App\Models\TrainingEvaluationQuestions;

class TrainingAssessmentTemplateCopier
{
    public function copyForTraining(Training $training): void
    {
        $templates = AssessmentTemplateQuestion::with('answers')
            ->where('category_id', $training->category_id)
            ->orderBy('id')
            ->get();

        foreach ($templates as $template) {
            match ($template->template_type) {
                'pre_test' => $this->copyPreTest($training, $template),
                'post_test' => $this->copyPostTest($training, $template),
                'training_evaluation' => $this->copyTrainingEvaluation($training, $template),
                'instructor_evaluation' => $this->copyInstructorEvaluation($training, $template),
            };
        }
    }

    private function copyPreTest(Training $training, AssessmentTemplateQuestion $template): void
    {
        $question = PreTestQuestions::create([
            'training_id' => $training->id,
            'question' => $template->question,
        ]);

        foreach ($template->answers as $answer) {
            PreTestAnswers::create([
                'pre_test_questions_id' => $question->id,
                'answer' => $answer->answer,
                'is_correct' => $answer->is_correct,
            ]);
        }
    }

    private function copyPostTest(Training $training, AssessmentTemplateQuestion $template): void
    {
        $question = PostTestQuestions::create([
            'training_id' => $training->id,
            'question' => $template->question,
        ]);

        foreach ($template->answers as $answer) {
            PostTestAnswers::create([
                'post_test_questions_id' => $question->id,
                'answer' => $answer->answer,
                'is_correct' => $answer->is_correct,
            ]);
        }
    }

    private function copyTrainingEvaluation(Training $training, AssessmentTemplateQuestion $template): void
    {
        $question = TrainingEvaluationQuestions::create([
            'training_id' => $training->id,
            'question' => $template->question,
            'type' => $template->question_type ?? 'scale',
        ]);

        if ($question->type === 'scale') {
            foreach ($template->answers as $answer) {
                TrainingEvaluationAnswers::create([
                    'teq_id' => $question->id,
                    'answers' => $answer->answer,
                ]);
            }
        }
    }

    private function copyInstructorEvaluation(Training $training, AssessmentTemplateQuestion $template): void
    {
        $question = InstructorEvaluationQuestions::create([
            'training_id' => $training->id,
            'question' => $template->question,
            'type' => $template->question_type ?? 'scale',
        ]);

        if ($question->type === 'scale') {
            foreach ($template->answers as $answer) {
                InstructorEvaluationAnswers::create([
                    'ieq_id' => $question->id,
                    'answers' => $answer->answer,
                ]);
            }
        }
    }
}
