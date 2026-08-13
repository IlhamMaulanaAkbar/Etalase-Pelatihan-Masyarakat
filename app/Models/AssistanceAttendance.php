<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceAttendance extends Model
{
    use HasFactory;

    protected $table = 'assistance_attendances';

    protected $fillable = [
        'assistance_id',
        'assistance_schedule_id',
        'participant_name',
        'status',
        'attendance_time',
        'note',
    ];

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }

    public function assistanceSchedule()
    {
        return $this->belongsTo(AssistanceSchedule::class, 'assistance_schedule_id');
    }
}
