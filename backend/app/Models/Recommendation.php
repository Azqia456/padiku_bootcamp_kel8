<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'planting_id',
        'category',
        'title',
        'description',
        'action_steps',
        'priority',
        'is_applied',
        'applied_at',
        'valid_until',
    ];

    protected $casts = [
        'is_applied' => 'boolean',
        'applied_at' => 'datetime',
        'valid_until' => 'date',
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
