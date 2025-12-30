<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookingSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $bookingId) {
            DB::table('booking_seats')->insert([
                'booking_id' => $bookingId,
                'seat_id' => rand(1, 50),
                'fare' => rand(300, 800),
                'passenger_name' => $faker->name(),
                'passenger_phone' => $faker->phoneNumber(),
            ]);
        }
    }

}
