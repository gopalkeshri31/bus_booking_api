<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    protected $fillable = [
        'user_id', // Add 'user_id' to the fillable attributes
        'bus_id',
        'seat_number',
        'booking_date'
        // Other fillable attributes
    ];
}
