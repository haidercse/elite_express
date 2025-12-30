<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Get valid user IDs
        $userIds = DB::table('users')->pluck('id')->toArray();

        // If no users exist, stop seeding
        if (empty($userIds)) {
            return;
        }

        // Get valid trip IDs
        $tripIds = DB::table('trips')->pluck('id')->toArray();

        if (empty($tripIds)) {
            return;
        }

        for ($i = 1; $i <= 50; $i++) {

            DB::table('bookings')->insert([
                'user_id' => $userIds[array_rand($userIds)],   // VALID user_id
                'trip_id' => $tripIds[array_rand($tripIds)],   // VALID trip_id
                'total_amount' => rand(100, 500),
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'booking_code' => $this->generateUniqueBookingCode(),
            ]);
        }
    }

    private function generateUniqueBookingCode()
    {
        do {
            $code = 'BK-' . rand(1000, 9999);
        } while (DB::table('bookings')->where('booking_code', $code)->exists());

        return $code;
    }
}