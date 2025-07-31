<?php

// InspectionItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InspectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'category',
        'item_name',
        'item_code',
        'condition',
        'percentage_rating',
        'priority',
        'measured_value',
        'acceptable_range',
        'within_spec',
        'estimated_repair_cost',
        'findings',
        'recommendations',
        'notes',
        'photo_references'
    ];

    protected $casts = [
        'percentage_rating' => 'decimal:2',
        'within_spec' => 'boolean',
        'estimated_repair_cost' => 'decimal:2',
        'photo_references' => 'array'
    ];

    // Relationships
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InspectionPhoto::class);
    }

    // Accessors
    public function getConditionColorAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'green',
            'good' => 'blue',
            'fair' => 'yellow',
            'poor' => 'orange',
            'failed' => 'red',
            'not_applicable' => 'gray',
            default => 'gray'
        };
    }

public function getPriorityColorAttribute(): string
{
    switch ($this->priority) {
        case 'low':
            return 'green';
        case 'medium':
            return 'yellow';
        case 'high':
            return 'orange';
        case 'critical':
            return 'red';
        default:
            return 'gray';
    }
}


    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeNeedsAttention($query)
    {
        return $query->whereIn('condition', ['poor', 'failed'])
                    ->orWhere('priority', 'critical');
    }

    public function scopePassedInspection($query)
    {
        return $query->whereIn('condition', ['excellent', 'good']);
    }
}