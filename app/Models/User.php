<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Creasi\Nusa\Models\Concerns\WithDistrict;
use Creasi\Nusa\Models\Concerns\WithProvince;
use Creasi\Nusa\Models\Concerns\WithRegency;
use Creasi\Nusa\Models\Concerns\WithVillage;
use Creasi\Nusa\Models\District as NusaDistrict;
use Creasi\Nusa\Models\Province as NusaProvince;
use Creasi\Nusa\Models\Regency as NusaRegency;
use Creasi\Nusa\Models\Village as NusaVillage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, WithProvince, WithRegency, WithDistrict, WithVillage;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'province_code',
        'regency_code',
        'district_code',
        'village_code',
        'job',
        'education',
        'education_institutions',
        'religion',
        'photo', // jika ingin menyimpan gambar nanti
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function training_users()
    {
        return $this->hasMany(TrainingUser::class, 'user_id');
    }

    public function assistance_users()
    {
        return $this->hasMany(AssistanceUser::class, 'user_id');
    }

    public function nusaProvince(): BelongsTo
    {
        return $this->belongsTo(NusaProvince::class, 'province_code', 'code');
    }

    public function nusaRegency(): BelongsTo
    {
        return $this->belongsTo(NusaRegency::class, 'regency_code', 'code');
    }

    public function nusaDistrict(): BelongsTo
    {
        return $this->belongsTo(NusaDistrict::class, 'district_code', 'code');
    }

    public function nusaVillage(): BelongsTo
    {
        return $this->belongsTo(NusaVillage::class, 'village_code', 'code');
    }
}
