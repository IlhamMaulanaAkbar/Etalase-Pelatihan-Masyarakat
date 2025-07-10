<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTestQuestions extends Model
{
    use HasFactory;

    protected $table = 'post_test_questions';

    protected $fillable = [
        'training_id',
        'question',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function answers()
    {
        return $this->hasMany(PostTestAnswers::class, 'post_test_questions_id');
    }
    
    public function userAnswers()
    {
        return $this->hasMany(PostTestUsersAnswers::class, 'post_test_questions_id');
    }
}
