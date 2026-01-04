<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSeatMap extends Model
{
    protected $fillable = [
        'trip_id',
        'seat_id',
        'status'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}