<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_types')->insert([
            ['name' => 'Hiace', 'seat_count' => 14, 'status' => 1],
            ['name' => 'Mini Micro', 'seat_count' => 8, 'status' => 1],
            ['name' => 'Bus', 'seat_count' => 40, 'status' => 1],
        ]);
    }
}
