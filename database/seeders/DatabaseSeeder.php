<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            SuperAdminSeeder::class,
            RolePermissionSeeder::class,
            UserProfileSeeder::class,
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
            RouteSeeder::class,
            TripSeeder::class,
            SeatSeeder::class,
            TripSeatStatusSeeder::class,
            BookingSeeder::class,
            BookingSeatSeeder::class,
            PaymentSeeder::class,
            MenuSeeder::class,

        ]);
    }
}
