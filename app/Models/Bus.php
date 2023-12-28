<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Define the relationship to seats
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
