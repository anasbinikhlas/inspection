<?php

// Location.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'phone',
        'email',
        'operating_hours',
        'services_offered',
        'mobile_service',
        'max_daily_appointments',
        'status'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'operating_hours' => 'array',
        'services_offered' => 'array',
        'mobile_service' => 'boolean'
    ];

    // Relationships
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Methods
    public function getFullAddressAttribute(): string
    {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ' ' . $this->zip_code;
    }

    public function isOpenOn($dayOfWeek): bool
    {
        return isset($this->operating_hours[$dayOfWeek]) && $this->operating_hours[$dayOfWeek] !== null;
    }

    public function getOpeningHours($dayOfWeek): ?array
    {
        return $this->operating_hours[$dayOfWeek] ?? null;
    }
}