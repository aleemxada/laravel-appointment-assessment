<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'scheduled_at',
        'status',
        'notes',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // Eloquent scope (Task 3 requirement)
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('scheduled_at');
    }

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
