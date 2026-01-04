<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();
        $tripIds = DB::table('trips')->pluck('id')->toArray();
        $seatIds = DB::table('seats')->pluck('id')->toArray();

        if (empty($userIds) || empty($tripIds) || empty($seatIds)) {
            return;
        }

        for ($i = 1; $i <= 50; $i++) {

            $fare = rand(100, 500);

            DB::table('bookings')->insert([
                'user_id' => $userIds[array_rand($userIds)],
                'trip_id' => $tripIds[array_rand($tripIds)],
                'seat_id' => $seatIds[array_rand($seatIds)],

                'passenger_name' => 'Passenger ' . $i,
                'passenger_phone' => '017' . rand(10000000, 99999999),

                'fare' => $fare,
                'total_amount' => $fare,

                'status' => 'confirmed',
                'payment_status' => 'paid',

                'booking_code' => $this->generateUniqueBookingCode(),
            ]);
        }
    }

    private function generateUniqueBookingCode()
    {
        do {
            $code = 'BK-' . rand(100000, 999999);
        } while (DB::table('bookings')->where('booking_code', $code)->exists());

        return $code;
    }
}