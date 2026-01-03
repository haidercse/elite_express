<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripSeatStatus extends Model
{
    protected $fillable = [
        'trip_id',
        'seat_id',
        'status',
        'fare',
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}