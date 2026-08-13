<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceSchedule extends Model
{
    use HasFactory;

    protected $table = 'assistance_schedules';

    protected $fillable = [
        'assistance_id',
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

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }

    public function assistanceAttendances()
    {
        return $this->hasMany(AssistanceAttendance::class, 'assistance_schedule_id');
    }
}
