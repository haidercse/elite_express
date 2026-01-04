<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // DASHBOARD (TOP)
        // ============================
        $dashboardGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Dashboard',
            'order' => 0
        ]);

        DB::table('menus')->insert([
            [
                'group_id' => $dashboardGroup,
                'title' => 'Dashboard',
                'icon' => 'ti-home',
                'route' => 'admin.dashboard',
                'permission' => null,
                'order' => 1
            ],
        ]);

        // ============================
        // TRANSPORT MANAGEMENT
        // ============================
        $transportGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Transport Management',
            'order' => 1
        ]);

        // Vehicle Types
        $vehicleTypeParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Vehicle Types',
            'icon' => 'ti-truck',
            'permission' => 'vehicle-type.view',
            'order' => 1
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $vehicleTypeParent,
                'title' => 'Vehicle Type List',
                'route' => 'admin.vehicle.types.index',
                'permission' => 'vehicle-type.view',
                'order' => 1
            ],
        ]);

        // Vehicles
        $vehicleParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Vehicles',
            'icon' => 'ti-truck',
            'permission' => 'vehicle.view',
            'order' => 2
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $vehicleParent,
                'title' => 'Vehicle List',
                'route' => 'admin.vehicles.index',
                'permission' => 'vehicle.view',
                'order' => 1
            ],
        ]);

        // Routes
        $routeParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Routes',
            'icon' => 'ti-direction',
            'permission' => 'route.view',
            'order' => 3
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $routeParent,
                'title' => 'Route List',
                'route' => 'admin.routes.index',
                'permission' => 'route.view',
                'order' => 1
            ],
        ]);

        // Trips
        $tripParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Trips',
            'icon' => 'ti-timer',
            'permission' => 'trip.view',
            'order' => 4
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $tripParent,
                'title' => 'Trip List',
                'route' => 'admin.trips.index',
                'permission' => 'trip.view',
                'order' => 1
            ],
        ]);

        // Seats
        $seatParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Seats',
            'icon' => 'ti-layout-grid2',
            'permission' => 'seat.view',
            'order' => 5
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $seatParent,
                'title' => 'Seat List',
                'route' => 'admin.seats.index',
                'permission' => 'seat.view',
                'order' => 1
            ],
        ]);

        // ⭐ ADD BOOKING MENU HERE
        $bookingParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Bookings',
            'icon' => 'ti-ticket',
            'permission' => 'booking.view',
            'order' => 6
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $bookingParent,
                'title' => 'Booking List',
                'route' => 'admin.bookings.index',
                'permission' => 'booking.view',
                'order' => 1
            ],
        ]);


        // ============================
        // SETTINGS (BOTTOM)
        // ============================

        $settingsGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Settings',
            'order' => 99
        ]);

        // Settings Parent
        $settingsParent = DB::table('menus')->insertGetId([
            'group_id' => $settingsGroup,
            'title' => 'Settings',
            'icon' => 'ti-settings',
            'permission' => null,
            'order' => 1
        ]);

        // Users (NO parent_id)
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'Users',
                'icon' => 'ti-user',
                'route' => 'admin.users.index',
                'permission' => 'users.view',
                'order' => 2
            ],
        ]);

        // Roles
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'Roles',
                'icon' => 'ti-lock',
                'route' => 'admin.roles.index',
                'permission' => 'role.view',
                'order' => 3
            ],
        ]);

        // Permissions
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'Permissions',
                'icon' => 'ti-key',
                'route' => 'admin.permissions.index',
                'permission' => 'permission.view',
                'order' => 4
            ],
        ]);

        // Menu Builder
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'Menu Builder',
                'icon' => 'ti-menu',
                'route' => 'admin.menus.index',
                'permission' => 'menu.view',
                'order' => 5
            ],
        ]);

        // Menu Groups
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'Menu Groups',
                'icon' => 'ti-layers',
                'route' => 'admin.menu-groups.index',
                'permission' => 'menu.view',
                'order' => 6
            ],
        ]);
        // System Settings (NEW)
        DB::table('menus')->insert([
            [
                'group_id' => $settingsGroup,
                'parent_id' => $settingsParent,
                'title' => 'System Settings',
                'icon' => 'ti-settings', // তুমি চাইলে ti-sliders বা ti-control-record নিতে পারো
                'route' => 'admin.settings.index', // তোমার settings page route
                'permission' => null, // চাইলে permission add করতে পারো
                'order' => 1.5 // Users এর আগে দেখাতে চাইলে 1.5 দাও
            ],
        ]);
    }
}