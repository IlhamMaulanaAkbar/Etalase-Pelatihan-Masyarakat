<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationQuestions extends Model
{
    use HasFactory;

    protected $table = 'training_evaluation_questions';

    protected $fillable = [
        'training_id',
        'question',
        'type',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function answers()
    {
        return $this->hasMany(TrainingEvaluationAnswers::class, 'training_evaluation_questions_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(TrainingEvaluationUsersAnswers::class, 'training_evaluation_questions_id');
    }
}
