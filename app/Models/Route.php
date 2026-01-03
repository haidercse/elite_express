<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'from_city',
        'to_city',
        'route_code',
        'slug',
        'distance_km',
        'approx_duration_minutes',
        'base_fare',
        'pickup_points',
        'drop_points',
        'is_two_way',
        'notes',
        'status',
    ];
}
