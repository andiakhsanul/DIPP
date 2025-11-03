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

    /**
     * Get batch status attribute (for backward compatibility)
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'closed';
        }

        $now = now();
        $registrationStart = $this->registration_start;
        $registrationEnd = $this->registration_end;
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        // Completed - training has ended
        if ($now->isAfter($endDate)) {
            return 'completed';
        }

        // Open - registration is currently open
        if ($now->between($registrationStart, $registrationEnd)) {
            return 'open';
        }

        // Scheduled - registration hasn't started or training hasn't started
        if ($now->isBefore($registrationStart) || $now->between($registrationEnd, $startDate)) {
            return 'scheduled';
        }

        // Default to scheduled
        return 'scheduled';
    }
}
