<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\TrainingUser;
use App\Models\PreTestQuestions;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';
    protected $fillable = [
        'training_name',
        'category_id',
        'start_date',
        'end_date',
        'deadline_date',
        'location',
        'status',
        'thumbnail_image',
        'description',
        'target_audience',
        'photo',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function participants()
    {
        return $this->hasMany(TrainingUser::class);
    }

    public function participant()
    {
        return $this->belongsToMany(User::class, 'training_users', 'training_id', 'user_id');
    }

    public function training_users()
    {
        return $this->hasMany(TrainingUser::class, 'training_id');
    }

    public function preTestQuestions()
    {
        return $this->hasMany(PreTestQuestions::class, 'training_id');
    }

    public function postTestQuestions()
    {
        return $this->hasMany(PostTestQuestions::class, 'training_id');
    }
}
