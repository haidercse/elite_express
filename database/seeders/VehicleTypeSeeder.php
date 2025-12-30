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
            ['name' => 'Hiace', 'code' => 'HIACE', 'description' => 'Standard Hiace'],
            ['name' => 'Mini Micro', 'code' => 'MINI_MICRO', 'description' => 'Mini Microbus'],
            ['name' => 'Bus', 'code' => 'BUS', 'description' => 'Full size bus'],
        ]);
    }
}
