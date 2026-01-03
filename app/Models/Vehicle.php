<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_type_id',
        'name',
        'plate_number',
        'total_seats',
        'driver_name',
        'driver_phone',
        'photo',
        'notes',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

}
