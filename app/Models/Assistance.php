<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $table = 'assistance';

    protected $fillable = [
        'assistance_name',
        'training_id',
        'start_date',
        'end_date',
        'deadline_date',
        'location',
        'status',
        'thumbnail_image',
        'description',
        'target_audience',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline_date' => 'date',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function participants()
    {
        return $this->hasMany(AssistanceUser::class, 'assistance_id');
    }

    public function assistance_users()
    {
        return $this->hasMany(AssistanceUser::class, 'assistance_id');
    }
}
