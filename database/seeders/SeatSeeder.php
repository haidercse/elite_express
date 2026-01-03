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

                $isWindow = in_array($i % 4, [1, 0]); // 1st & 4th column
                $isAisle = in_array($i % 4, [2, 3]);

                DB::table('seats')->insert([
                    'vehicle_id' => $vehicleId,
                    'seat_number' => 'S' . $i,
                    'seat_label' => chr(64 + ceil($i / 4)) . ($i % 4 ?: 4),

                    'seat_type' => $seatType,
                    'seat_category' => $seatType === 'front' ? 'vip' : 'regular',

                    'is_window_seat' => $isWindow,
                    'is_aisle_seat' => $isAisle,
                    'is_near_door' => $i == 1 ? true : false,

                    'base_fare_multiplier' =>
                        $seatType === 'front' ? 1.20 :
                        ($seatType === 'back' ? 0.90 : 1.00),

                    'seat_fare_override' => null,

                    'position_row' => ceil($i / 4),
                    'position_column' => ($i % 4) ?: 4,

                    'seat_group' => $i <= $totalSeats / 2 ? 'left' : 'right',

                    'is_reserved' => false,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
