<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Trip;
use App\Models\TripSeatStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeatStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = Trip::all();

        foreach ($trips as $trip) {

            $seats = Seat::where('vehicle_id', $trip->vehicle_id)->get();

            foreach ($seats as $seat) {
                TripSeatStatus::create([
                    'trip_id' => $trip->id,
                    'seat_id' => $seat->id,
                    'status' => 'available',
                    'fare' => $trip->base_fare * $seat->base_fare_multiplier,
                ]);
            }
        }
    }
}
