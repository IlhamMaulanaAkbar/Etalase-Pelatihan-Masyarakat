<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationUsersAnswers extends Model
{
    use HasFactory;

    protected $table = 'training_evaluation_users_answers';

    protected $fillable = [
        'training_evaluation_questions_id',
        'users_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(TrainingEvaluationQuestions::class, 'training_evaluation_questions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
