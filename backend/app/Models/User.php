<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'nik',      
        'phone',
        'address',
        'district',
        'village',   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function plantings()
    {
        return $this->hasMany(Planting::class);
    }

    public function pestReports()
    {
        return $this->hasMany(PestReport::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function fertilizerSchedules()
    {
        return $this->hasMany(FertilizerSchedule::class);
    }
}