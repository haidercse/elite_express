<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'route_id',
        'vehicle_id',
        'trip_code',
        'date',
        'departure_time',
        'arrival_time',
        'actual_departure_time',
        'actual_arrival_time',
        'base_fare',
        'fare_override',
        'seat_layout',
        'is_round_trip',
        'remarks',
        'status',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
