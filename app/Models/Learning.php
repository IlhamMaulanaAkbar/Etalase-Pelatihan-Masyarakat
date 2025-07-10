<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    protected $table = 'learnings';

    protected $fillable = [
        'video_name',
        'video_url',
        'uploaded_at',
        'type',
    ];

    protected $casts = [
        'uploaded_at' => 'date',
    ];
}
