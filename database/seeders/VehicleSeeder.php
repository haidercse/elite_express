<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            DB::table('vehicles')->insert([
                'vehicle_type_id' => rand(1, 3), // Hice, Bus, etc.
                'name' => 'Vehicle-' . $i,
                'plate_number' => strtoupper($faker->bothify('??-####')),
                'total_seats' => rand(12, 40),

                // New recommended fields
                'driver_name' => $faker->name(),
                'driver_phone' => $faker->phoneNumber(),
                'photo' => null, // or $faker->imageUrl()
                'notes' => $faker->sentence(),

                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
