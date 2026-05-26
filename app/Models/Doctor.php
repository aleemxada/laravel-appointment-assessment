<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'license_number',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specialization');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
