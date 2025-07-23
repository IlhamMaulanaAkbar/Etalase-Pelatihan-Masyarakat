<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceUser extends Model
{
    use HasFactory;

    protected $table = 'assistance_users';

    protected $fillable = [
        'user_id',
        'assistance_id',
        'registration_number',
        'status',
        'is_approved',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }
}
