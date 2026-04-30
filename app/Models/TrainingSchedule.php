<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;

    protected $table = 'training_schedules';
    protected $fillable = [
        'training_id',
        'meeting_number',
        'date',
        'start_time',
        'end_time',
        'material_title',
        'material_description',
        'speaker_name',
        'file',
        'duration',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function trainingAttendances()
    {
        return $this->hasMany(TrainingAttendance::class, 'training_schedule_id');
    }
}
