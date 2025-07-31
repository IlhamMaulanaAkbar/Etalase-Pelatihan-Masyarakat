<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonsAssistance extends Model
{
    use HasFactory;

    protected $table = 'lessons_assistance';
    protected $fillable = [
        'assistance_id',
        'name',
        'file',
        'duration',
    ];

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }
}
