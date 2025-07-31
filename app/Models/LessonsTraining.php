<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonsTraining extends Model
{
    use HasFactory;

    protected $table = 'lessons_training';
    protected $fillable = [
        'training_id',
        'name',
        'file',
        'duration',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
}
