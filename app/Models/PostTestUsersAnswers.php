<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTestUsersAnswers extends Model
{
    use HasFactory;

    protected $table = 'post_test_users_answers';

    protected $fillable = [
        'post_test_questions_id',
        'users_id',
        'answer',
    ];

    public function question()
    {
        return $this->belongsTo(PostTestQuestions::class, 'post_test_questions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function answer()
    {
        return $this->belongsTo(PostTestAnswers::class, 'answer');
    }
}
