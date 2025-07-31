<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $casts = [
        'issue_date' => 'date',
    ];

    protected $fillable = [
        'training_id',
        'certificate_number',
        'signature_file',
        'name_of_leader',
        'leadership_position',
        'issue_date',
        'identity_number',
    ];
    
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
}
