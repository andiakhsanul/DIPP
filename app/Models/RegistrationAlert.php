<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationAlert extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'message',
        'alert_type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active alerts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the SweetAlert icon based on alert type.
     *
     * @return string
     */
    public function getSwalIconAttribute(): string
    {
        return match ($this->alert_type) {
            'warning' => 'warning',
            'error' => 'error',
            'success' => 'success',
            default => 'info',
        };
    }
}
