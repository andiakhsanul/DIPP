<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_name',
        'training_type',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
        'quota',
        'max_participants',
        'location',
        'description',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start' => 'date',
        'registration_end' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get registrations for this batch
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get approved registrations count
     */
    public function approvedCount()
    {
        return $this->registrations()->where('status', 'approved')->count();
    }

    /**
     * Check if batch is full
     */
    public function isFull(): bool
    {
        return $this->approvedCount() >= $this->quota;
    }

    /**
     * Get available slots
     */
    public function availableSlots(): int
    {
        return max(0, $this->quota - $this->approvedCount());
    }

    /**
     * Scope for active batches
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
