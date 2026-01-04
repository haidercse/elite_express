<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'vehicle_id',
        'seat_number',
        'seat_label',
        'seat_type',
        'seat_category',
        'is_window_seat',
        'is_aisle_seat',
        'is_near_door',
        'base_fare_multiplier',
        'seat_fare_override',
        'position_row',
        'position_column',
        'seat_group',
        'is_reserved',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function tripMaps()
    {
        return $this->hasMany(TripSeatMap::class);
    }
}