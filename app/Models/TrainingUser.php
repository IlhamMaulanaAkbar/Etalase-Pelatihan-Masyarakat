<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingUser extends Model
{
    use HasFactory;

    protected $table = 'training_users';

    protected $fillable = [
        'user_id',
        'training_id',
        'registration_number',
        'status',
        'letter_statement',
        'letter_recommendation',
        'is_approved',
        'started_pretest',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // User.php
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
