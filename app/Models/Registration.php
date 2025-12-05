<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'batch_id',
        'registration_date',
        'status',
        'payment_receipt_url',
        'npwp_ktp',
        'surat_tugas',
        'pekerti_certificate',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
    ];

    /**
     * Get the user that owns the registration
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the batch for this registration
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Scope for pending registrations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved registrations
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected registrations
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Approve registration
     */
    public function approve()
    {
        $this->status = 'approved';
        $this->save();
    }

    /**
     * Reject registration
     */
    public function reject()
    {
        $this->status = 'rejected';
        $this->save();
    }
}
