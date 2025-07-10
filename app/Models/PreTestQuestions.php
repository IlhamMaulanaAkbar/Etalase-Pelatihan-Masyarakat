<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training;
use App\Models\PreTestAnswer;
use App\Models\PreTestUsersAnswer;

class PreTestQuestions extends Model
{
    use HasFactory;

    protected $table = 'pre_test_questions';

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
        return $this->hasMany(PreTestAnswers::class, 'pre_test_questions_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(PreTestUsersAnswers::class, 'pre_test_questions_id');
    }
}
