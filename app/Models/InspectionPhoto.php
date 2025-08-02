<?php

// InspectionPhoto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class InspectionPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'inspection_item_id',
        'filename',
        'original_filename',
        'file_path',
        'file_url',
        'mime_type',
        'file_size',
        'width',
        'height',
        'category',
        'title',
        'description',
        'photo_type',
        'vehicle_position',
        'damage_coordinates',
        'sequence_order',
        'exif_data',
        'taken_at',
        'is_primary',
        'include_in_report',
        'customer_visible'
    ];

    protected $casts = [
        'damage_coordinates' => 'array',
        'exif_data' => 'array',
        'taken_at' => 'datetime',
        'is_primary' => 'boolean',
        'include_in_report' => 'boolean',
        'customer_visible' => 'boolean'
    ];

    // Relationships
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function inspectionItem(): BelongsTo
    {
        return $this->belongsTo(InspectionItem::class);
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return $this->file_url ?: Storage::url($this->file_path);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeForReport($query)
    {
        return $query->where('include_in_report', true);
    }

    public function scopeCustomerVisible($query)
    {
        return $query->where('customer_visible', true);
    }
}
