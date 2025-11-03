<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // Set user_id as primary key (matching migration)
    protected $primaryKey = 'user_id';

    // Disable auto-increment since user_id is foreign key
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'full_name',
        'nidn',
        'university',
        'phone_number',
    ];

    /**
     * Get the user that owns the profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
