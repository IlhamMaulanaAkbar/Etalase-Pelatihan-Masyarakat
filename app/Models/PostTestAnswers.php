<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTestAnswers extends Model
{
    use HasFactory;

    protected $table = 'post_test_answers';

    protected $fillable = [
        'post_test_questions_id',
        'answer',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(PostTestQuestions::class, 'post_test_questions_id');
    }
}
