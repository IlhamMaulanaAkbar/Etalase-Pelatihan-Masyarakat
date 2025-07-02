<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name'
    ];

    // di model Category
    public function trainings()
    {
        return $this->hasMany(Training::class, 'category_id');
    }
}
