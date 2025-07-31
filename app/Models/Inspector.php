<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspector extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'license_number',
        'license_expiry',
        'certifications',
        'specializations',
        'status',
        'hourly_rate',
        'hire_date',
        'bio',
        'profile_photo'
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'hire_date' => 'date',
        'certifications' => 'array',
        'specializations' => 'array',
        'hourly_rate' => 'decimal:2'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsLicenseValidAttribute(): bool
    {
        return $this->license_expiry && $this->license_expiry->isFuture();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailableFor($query, $date, $time)
    {
        return $query->where('status', 'active')
                    ->whereDoesntHave('appointments', function ($q) use ($date, $time) {
                        $q->where('appointment_date', $date)
                          ->where('appointment_time', $time)
                          ->whereIn('status', ['confirmed', 'in_progress']);
                    });
    }
}