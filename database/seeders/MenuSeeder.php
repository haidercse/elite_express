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

        // ============================
        // SETTINGS (BOTTOM)
        // ============================
        $settingsGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Settings',
            'order' => 99
        ]);

        // Menu Builder
        $menuParent = DB::table('menus')->insertGetId([
            'group_id' => $settingsGroup,
            'title' => 'Menu Builder',
            'icon' => 'ti-menu',
            'permission' => 'menu.view',
            'order' => 1
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $menuParent,
                'title' => 'Menu List',
                'route' => 'admin.menus.index',
                'permission' => 'menu.view',
                'order' => 1
            ],
            [
                'parent_id' => $menuParent,
                'title' => 'Menu Groups',
                'route' => 'admin.menu-groups.index',
                'permission' => 'menu.view',
                'order' => 2
            ],
        ]);

        // Roles
        $roleParent = DB::table('menus')->insertGetId([
            'group_id' => $settingsGroup,
            'title' => 'Roles',
            'icon' => 'ti-lock',
            'permission' => 'role.view',
            'order' => 2
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $roleParent,
                'title' => 'Role List',
                'route' => 'admin.roles.index',
                'permission' => 'role.view',
                'order' => 1
            ],
        ]);

        // Permissions
        $permissionParent = DB::table('menus')->insertGetId([
            'group_id' => $settingsGroup,
            'title' => 'Permissions',
            'icon' => 'ti-key',
            'permission' => 'permission.view',
            'order' => 3
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $permissionParent,
                'title' => 'Permissions List',
                'route' => 'admin.permissions.index',
                'permission' => 'permission.view',
                'order' => 1
            ],
        ]);

        // Users
        $userParent = DB::table('menus')->insertGetId([
            'group_id' => $settingsGroup,
            'title' => 'Users',
            'icon' => 'ti-user',
            'permission' => 'users.view',
            'order' => 4
        ]);

        DB::table('menus')->insert([
            [
                'parent_id' => $userParent,
                'title' => 'User List',
                'route' => 'admin.users.index',
                'permission' => 'users.view',
                'order' => 1
            ],
        ]);
    }
}