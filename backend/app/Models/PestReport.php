<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planting_id',
        'pest_type',
        'description',
        'latitude',
        'longitude',
        'severity',
        'status',
        'report_date',
        'action_taken',
    ];

    protected $casts = [
        'report_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planting()
    {
        return $this->belongsTo(Planting::class);
    }
}
