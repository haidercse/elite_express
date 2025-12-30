<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $vehicleId) {

            $totalSeats = DB::table('vehicles')->where('id', $vehicleId)->value('total_seats');

            for ($i = 1; $i <= $totalSeats; $i++) {

                $seatType = $i <= 4 ? 'front' : ($i >= $totalSeats - 3 ? 'back' : 'middle');

                DB::table('seats')->insert([
                    'vehicle_id' => $vehicleId,
                    'seat_number' => 'S' . $i,
                    'seat_type' => $seatType,
                    'base_fare_multiplier' =>
                    $seatType === 'front' ? 1.20 : ($seatType === 'back' ? 0.90 : 1.00),
                    'is_reserved' => false,
                    'position_row' => ceil($i / 4),
                    'position_column' => ($i % 4) ?: 4,
                ]);
            }
        }
    }
}
