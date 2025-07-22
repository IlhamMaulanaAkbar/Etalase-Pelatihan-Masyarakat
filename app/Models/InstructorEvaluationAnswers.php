<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorEvaluationAnswers extends Model
{
    use HasFactory;

    protected $table = 'instructor_evaluation_answers';

    protected $fillable = [
        'ieq_id',
        'answers',
    ];

    public function question()
    {
        return $this->belongsTo(InstructorEvaluationQuestions::class, 'ieq_id');
    }
}
