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
        'no_registrasi',
        'status',
        'is_approved',
        'verified_at',
    ];

    // User.php
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'training_users')
            ->withPivot('status', 'is_approved', 'verified_at', 'no_registrasi')
            ->withTimestamps();
    }

    // Training.php
    public function users()
    {
        return $this->belongsToMany(User::class, 'training_users')
            ->withPivot('status', 'is_approved', 'verified_at', 'no_registrasi')
            ->withTimestamps();
    }
}
