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
        'admin_notes',
        'source',
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
        'mileage' => 'integer',
        'vehicle_year' => 'integer',
        'estimated_duration' => 'integer',
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
        return trim("{$this->vehicle_year} {$this->vehicle_make} {$this->vehicle_model}");
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
            'no_show' => 'gray',
            'rescheduled' => 'indigo',
            default => 'gray',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        $color = $this->status_color;
        $statusText = ucfirst(str_replace('_', ' ', $this->status));
        
        return "<span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800'>{$statusText}</span>";
    }

    public function getPackageBadgeAttribute(): string
    {
        $packageText = ucfirst($this->package_type);
        
        return "<span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800'>{$packageText}</span>";
    }

    public function getFormattedAppointmentDateAttribute(): ?string
    {
        return $this->appointment_date ? $this->appointment_date->format('F j, Y') : null;
    }

    public function getFormattedAppointmentTimeAttribute(): ?string
    {
        return $this->appointment_time ? $this->appointment_time->format('g:i A') : null;
    }

    public function getFormattedAppointmentDatetimeAttribute(): ?string
    {
        if (!$this->appointment_date || !$this->appointment_time) {
            return null;
        }
        
        return $this->appointment_date->format('M j, Y') . ' at ' . $this->appointment_time->format('g:i A');
    }

    public function getFormattedMileageAttribute(): ?string
    {
        return $this->mileage ? number_format($this->mileage) . ' miles' : null;
    }

    public function getIsUpcomingAttribute(): bool
    {
        if (!$this->appointment_date) {
            return false;
        }

        return $this->appointment_date->isFuture() && 
               in_array($this->status, ['pending', 'confirmed', 'rescheduled']);
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->appointment_date ? $this->appointment_date->isToday() : false;
    }

    public function getIsPastAttribute(): bool
    {
        return $this->appointment_date ? $this->appointment_date->isPast() : false;
    }

    public function getCanBeCancelledAttribute(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'rescheduled']);
    }

    public function getCanBeRescheduledAttribute(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'rescheduled']);
    }

    public function getCanBeConfirmedAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getCanCreateInspectionAttribute(): bool
    {
        return in_array($this->status, ['confirmed', 'in_progress']) && !$this->inspection;
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                     ->whereIn('status', ['pending', 'confirmed', 'rescheduled'])
                     ->orderBy('appointment_date')
                     ->orderBy('appointment_time');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today())
                     ->orderBy('appointment_time');
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
                     ->orderBy('appointment_date', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('appointment_number', 'LIKE', "%{$search}%")
              ->orWhere('vehicle_make', 'LIKE', "%{$search}%")
              ->orWhere('vehicle_model', 'LIKE', "%{$search}%")
              ->orWhere('vin', 'LIKE', "%{$search}%")
              ->orWhere('license_plate', 'LIKE', "%{$search}%")
              ->orWhereHas('customer', function($q) use ($search) {
                  $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
              });
        });
    }

    public function scopeDateRange($query, $startDate, $endDate = null)
    {
        if ($startDate) {
            $query->where('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('appointment_date', '<=', $endDate);
        }

        return $query;
    }

    public function scopeLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    public function scopeInspector($query, $inspectorId)
    {
        return $query->where('inspector_id', $inspectorId);
    }

    public function scopePackageType($query, $packageType)
    {
        return $query->where('package_type', $packageType);
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

    public static function getAvailableTimeSlots($date, $locationId, $maxPerSlot = 5)
    {
        $baseSlots = [
            ['time' => '09:00', 'display' => '9:00 AM'],
            ['time' => '10:00', 'display' => '10:00 AM'],
            ['time' => '11:00', 'display' => '11:00 AM'],
            ['time' => '12:00', 'display' => '12:00 PM'],
            ['time' => '14:00', 'display' => '2:00 PM'],
            ['time' => '15:00', 'display' => '3:00 PM'],
            ['time' => '16:00', 'display' => '4:00 PM'],
            ['time' => '17:00', 'display' => '5:00 PM']
        ];

        $availableSlots = [];

        foreach ($baseSlots as $slot) {
            $bookedCount = self::where('appointment_date', $date)
                ->where('location_id', $locationId)
                ->whereTime('appointment_time', $slot['time'])
                ->whereNotIn('status', ['cancelled', 'no_show'])
                ->count();

            if ($bookedCount < $maxPerSlot) {
                $availableSlots[] = [
                    'time' => $slot['time'],
                    'display' => $slot['display'],
                    'available' => $maxPerSlot - $bookedCount
                ];
            }
        }

        return $availableSlots;
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

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->appointment_number)) {
                $appointment->appointment_number = self::generateAppointmentNumber();
            }

            if (empty($appointment->source)) {
                $appointment->source = 'frontend';
            }
        });
    }
}