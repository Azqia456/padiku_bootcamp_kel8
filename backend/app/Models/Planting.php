<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_name',
        'latitude',
        'longitude',
        'area_hectares',
        'planting_date',
        'rice_variety',
        'status',
        'expected_harvest_date',
        'notes',
    ];

    protected $casts = [
        'planting_date' => 'date',
        'expected_harvest_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'area_hectares' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pestReports()
    {
        return $this->hasMany(PestReport::class);
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
