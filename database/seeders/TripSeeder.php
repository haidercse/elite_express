<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('trips')->insert([
                'route_id' => rand(1, 2),
                'vehicle_id' => rand(1, 5),
                'date' => $faker->dateTimeBetween('now', '+7 days'),
                'departure_time' => $faker->time('H:i'),
                'arrival_time' => $faker->time('H:i'),
                'base_fare' => rand(300, 600),
                'status' => 'scheduled',
            ]);
        }
    }

}
