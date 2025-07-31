<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_number',
        'customer_id',
        'location_id',
        'inspector_id',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_type',
        'vin',
        'license_plate',
        'mileage',
        'color',
        'package_type',
        'price',
        'appointment_date',
        'appointment_time',
        'estimated_duration',
        'status',
        'customer_notes',
        'internal_notes',
        'cancellation_reason',
        'confirmed_at',
        'started_at',
        'completed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }

    public function inspection(): HasOne
    {
        return $this->hasOne(Inspection::class);
    }

    // Accessors
    public function getVehicleFullNameAttribute(): string
    {
        return $this->vehicle_year . ' ' . $this->vehicle_make . ' ' . $this->vehicle_model;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'in_progress' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            'rescheduled' => 'orange',
            'no_show' => 'gray',
            default => 'gray'
        };
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today())
                    ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Methods
    public static function generateAppointmentNumber(): string
    {
        $prefix = 'APPT-' . date('Y') . '-';
        $lastNumber = static::where('appointment_number', 'like', $prefix . '%')
                           ->orderBy('appointment_number', 'desc')
                           ->value('appointment_number');
        
        if ($lastNumber) {
            $number = (int) substr($lastNumber, -3) + 1;
        } else {
            $number = 1;
        }
        
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->appointment_date->isAfter(today());
    }

    public function canBeRescheduled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'rescheduled']) && 
               $this->appointment_date->isAfter(today());
    }
}