<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreTestUsersAnswers extends Model
{
    use HasFactory;

    protected $table = 'pre_test_users_answers';

    protected $fillable = [
        'pre_test_questions_id',
        'users_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(PreTestQuestions::class, 'pre_test_questions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function answer()
    {
        return $this->belongsTo(PreTestAnswers::class, 'answer');
    }
    
}
