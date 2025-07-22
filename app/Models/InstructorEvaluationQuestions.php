<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorEvaluationQuestions extends Model
{
    use HasFactory;

    protected $table = 'instructor_evaluation_questions';

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
        return $this->hasMany(InstructorEvaluationAnswers::class, 'ieq_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(InstructorEvaluationUsersAnswers::class, 'ieq_id');
    }
}
