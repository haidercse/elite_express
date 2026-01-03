<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->insert([
            [
                'from_city' => 'Maijdee',
                'to_city' => 'Dhaka',
                'route_code' => 'MD-DHK-01',
                'slug' => 'maijdee-to-dhaka',
                'distance_km' => 180,
                'approx_duration_minutes' => 240,
                'base_fare' => 550,
                'pickup_points' => json_encode(['Maijdee Bus Stand', 'Sonapur']),
                'drop_points' => json_encode(['Sayedabad', 'Jatrabari']),
                'is_two_way' => true,
                'status' => 'active',
            ],
            [
                'from_city' => 'Dhaka',
                'to_city' => 'Maijdee',
                'route_code' => 'DHK-MD-01',
                'slug' => 'dhaka-to-maijdee',
                'distance_km' => 180,
                'approx_duration_minutes' => 240,
                'base_fare' => 550,
                'pickup_points' => json_encode(['Sayedabad', 'Jatrabari']),
                'drop_points' => json_encode(['Maijdee Bus Stand', 'Sonapur']),
                'is_two_way' => true,
                'status' => 'active',
            ],
        ]);
    }

}
