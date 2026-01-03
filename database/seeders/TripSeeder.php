<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trips')->insert([
            [
                'trip_code' => 'TRIP-' . now()->format('Ymd') . '-' . Str::random(4),
                'route_id' => 1,
                'vehicle_id' => 1,
                'date' => now()->toDateString(),
                'departure_time' => '08:00:00',
                'arrival_time' => '12:00:00',
                'base_fare' => 550,
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'trip_code' => 'TRIP-' . now()->format('Ymd') . '-' . Str::random(4),
                'route_id' => 2,
                'vehicle_id' => 2,
                'date' => now()->toDateString(),
                'departure_time' => '14:00:00',
                'arrival_time' => '18:00:00',
                'base_fare' => 550,
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

}
