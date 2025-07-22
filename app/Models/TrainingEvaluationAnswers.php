<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationAnswers extends Model
{
    use HasFactory;

    protected $table = 'training_evaluation_answers';

    protected $fillable = [
        'teq_id',
        'answers',
    ];

    public function question()
    {
        return $this->belongsTo(TrainingEvaluationQuestions::class, 'teq_id');
    }
}
