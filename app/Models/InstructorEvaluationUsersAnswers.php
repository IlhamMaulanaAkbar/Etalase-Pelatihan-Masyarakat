<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorEvaluationUsersAnswers extends Model
{
    use HasFactory;

    protected $table = 'instructor_evaluation_users_answers';

    protected $fillable = [
        'ieq_id',
        'users_id',
        'answers',
    ];

    public function question()
    {
        return $this->belongsTo(InstructorEvaluationQuestions::class, 'ieq_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
