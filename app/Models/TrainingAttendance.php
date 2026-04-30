<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAttendance extends Model
{
    use HasFactory;

    protected $table = 'training_attendances';

    protected $fillable = [
        'training_id',
        'training_schedule_id',
        'participant_name',
        'status',
        'attendance_time',
        'note',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function trainingSchedule()
    {
        return $this->belongsTo(TrainingSchedule::class, 'training_schedule_id');
    }
}
