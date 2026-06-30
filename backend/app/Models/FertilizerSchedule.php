<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planting_id',
        'fertilizer_type',
        'amount_kg',
        'scheduled_date',
        'status',
        'applied_date',
        'notes',
        'priority',
        'delivery_method',
        'officer_in_charge',
    ];

    protected $casts = [
        'amount_kg' => 'decimal:2',
        'scheduled_date' => 'date',
        'applied_date' => 'date',
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
