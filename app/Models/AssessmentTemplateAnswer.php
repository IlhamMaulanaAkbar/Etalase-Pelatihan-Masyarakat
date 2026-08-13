<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTemplateAnswer extends Model
{
    use HasFactory;

    protected $table = 'assessment_template_answers';

    protected $fillable = [
        'assessment_template_question_id',
        'answer',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(AssessmentTemplateQuestion::class, 'assessment_template_question_id');
    }
}
