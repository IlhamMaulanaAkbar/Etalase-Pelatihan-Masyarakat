<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationAnswers extends Model
{
    use HasFactory;

    protected $table = 'training_evaluation_answers';

    protected $fillable = [
        'training_evaluation_questions_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(TrainingEvaluationQuestions::class, 'training_evaluation_questions_id');
    }
}
