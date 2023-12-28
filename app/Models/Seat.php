<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    protected $fillable = [
        'bus_id',
        'seat_number',
        'is_booked', // Add 'is_booked' to the fillable attributes
        // Add other fillable attributes here
    ];
}
