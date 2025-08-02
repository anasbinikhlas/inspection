<?php

// Inspection.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_number',
        'appointment_id',
        'inspector_id',
        'overall_score',
        'overall_condition',
        'recommendation',
        'engine_transmission_score',
        'brakes_score',
        'suspension_steering_score',
        'interior_score',
        'ac_heater_score',
        'electrical_score',
        'exterior_body_score',
        'tyres_score',
        'frame_score',
        'test_drive_score',
        'immediate_repairs_cost',
        'future_maintenance_cost',
        'estimated_value',
        'summary',
        'major_issues',
        'minor_issues',
        'recommendations',
        'inspector_notes',
        'test_drive_performed',
        'test_drive_distance',
        'test_drive_notes',
        'status',
        'started_at',
        'completed_at',
        'reviewed_at',
        'delivered_at'
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
        'engine_transmission_score' => 'decimal:2',
        'brakes_score' => 'decimal:2',
        'suspension_steering_score' => 'decimal:2',
        'interior_score' => 'decimal:2',
        'ac_heater_score' => 'decimal:2',
        'electrical_score' => 'decimal:2',
        'exterior_body_score' => 'decimal:2',
        'tyres_score' => 'decimal:2',
        'frame_score' => 'decimal:2',
        'test_drive_score' => 'decimal:2',
        'immediate_repairs_cost' => 'decimal:2',
        'future_maintenance_cost' => 'decimal:2',
        'estimated_value' => 'decimal:2',
        'test_drive_performed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    // Relationships
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InspectionItem::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InspectionPhoto::class);
    }

    // Accessors
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'in_progress' => 'yellow',
            'completed' => 'green',
            'reviewed' => 'blue',
            'delivered' => 'purple',
            default => 'gray'
        };
    }

    public function getOverallConditionColorAttribute(): string
    {
        return match($this->overall_condition) {
            'excellent' => 'green',
            'good' => 'blue',
            'fair' => 'yellow',
            'poor' => 'orange',
            'needs_attention' => 'red',
            default => 'gray'
        };
    }

    public function getRecommendationColorAttribute(): string
    {
        return match($this->recommendation) {
            'buy' => 'green',
            'negotiate' => 'blue',
            'minor_repairs' => 'yellow',
            'major_repairs' => 'orange',
            'avoid' => 'red',
            default => 'gray'
        };
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // Methods
    public static function generateInspectionNumber(): string
    {
        $prefix = 'INS-' . date('Y') . '-';
        $lastNumber = static::where('inspection_number', 'like', $prefix . '%')
                           ->orderBy('inspection_number', 'desc')
                           ->value('inspection_number');
        
        if ($lastNumber) {
            $number = (int) substr($lastNumber, -3) + 1;
        } else {
            $number = 1;
        }
        
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function calculateOverallScore(): float
    {
        $scores = [
            $this->engine_transmission_score,
            $this->brakes_score,
            $this->suspension_steering_score,
            $this->interior_score,
            $this->ac_heater_score,
            $this->electrical_score,
            $this->exterior_body_score,
            $this->tyres_score,
            $this->frame_score,
            $this->test_drive_score
        ];

        $validScores = array_filter($scores, function($score) {
            return $score !== null;
        });

        return count($validScores) > 0 ? array_sum($validScores) / count($validScores) : 0;
    }
}
