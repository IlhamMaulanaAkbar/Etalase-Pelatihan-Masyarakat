<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTemplateQuestion extends Model
{
    use HasFactory;

    protected $table = 'assessment_template_questions';

    protected $fillable = [
        'category_id',
        'template_type',
        'question',
        'question_type',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function answers()
    {
        return $this->hasMany(AssessmentTemplateAnswer::class, 'assessment_template_question_id');
    }
}
