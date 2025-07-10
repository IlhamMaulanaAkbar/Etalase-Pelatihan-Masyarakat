<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PreTestQuestion;

class PreTestAnswers extends Model
{
    use HasFactory;

    protected $table = 'pre_test_answers';
    protected $fillable = [
        'pre_test_questions_id',
        'answer',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(PreTestQuestions::class, 'pre_test_questions_id');
    }
}
