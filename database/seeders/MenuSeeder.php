<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // MENU MANAGEMENT
        // ============================
        $menuGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Menu Management',
            'order' => 1
        ]);

        $menuParent = DB::table('menus')->insertGetId([
            'group_id' => $menuGroup,
            'title' => 'Menus',
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
                'title' => 'Menu Group',
                'route' => 'admin.menu-groups.index',
                'permission' => 'menu.view',
                'order' => 2
            ],
        ]);


        // ============================
        // ROLE MANAGEMENT
        // ============================
        $roleGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Role Management',
            'order' => 2
        ]);

        $roleParent = DB::table('menus')->insertGetId([
            'group_id' => $roleGroup,
            'title' => 'Roles',
            'icon' => 'ti-lock',
            'permission' => 'role.view',
            'order' => 1
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


        // ============================
        // PERMISSION MANAGEMENT
        // ============================
        $permissionGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Permission Management',
            'order' => 3
        ]);

        $permissionParent = DB::table('menus')->insertGetId([
            'group_id' => $permissionGroup,
            'title' => 'Permissions',
            'icon' => 'ti-key',
            'permission' => 'permission.view',
            'order' => 1
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


        // ============================
        // USER MANAGEMENT
        // ============================
        $userGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'User Management',
            'order' => 4
        ]);

        $userParent = DB::table('menus')->insertGetId([
            'group_id' => $userGroup,
            'title' => 'Users',
            'icon' => 'ti-user',
            'permission' => 'users.view',
            'order' => 1
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


        // ============================
        // TRANSPORT MANAGEMENT (NEW)
        // ============================
        $transportGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Transport Management',
            'order' => 5
        ]);

        // Parent menu
        $vehicleTypeParent = DB::table('menus')->insertGetId([
            'group_id' => $transportGroup,
            'title' => 'Vehicle Types',
            'icon' => 'ti-truck',
            'permission' => 'vehicle-type.view',
            'order' => 1
        ]);

        // Submenu
        DB::table('menus')->insert([
            [
                'parent_id' => $vehicleTypeParent,
                'title' => 'Vehicle Type List',
                'route' => 'admin.vehicle.types.index',
                'permission' => 'vehicle-type.view',
                'order' => 1
            ],
        ]);

        // ============================
// VEHICLE MANAGEMENT
// ============================
        $vehicleGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Vehicle Management',
            'order' => 6
        ]);

        // Parent menu
        $vehicleParent = DB::table('menus')->insertGetId([
            'group_id' => $vehicleGroup,
            'title' => 'Vehicles',
            'icon' => 'ti-truck',
            'permission' => 'vehicle.view',
            'order' => 1
        ]);

        // Submenu
        DB::table('menus')->insert([
            [
                'parent_id' => $vehicleParent,
                'title' => 'Vehicle List',
                'route' => 'admin.vehicles.index',
                'permission' => 'vehicle.view',
                'order' => 1
            ],
        ]);

        // ============================
// ROUTE MANAGEMENT
// ============================
        $routeGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Route Management',
            'order' => 7
        ]);

        // Parent menu
        $routeParent = DB::table('menus')->insertGetId([
            'group_id' => $routeGroup,
            'title' => 'Routes',
            'icon' => 'ti-direction',
            'permission' => 'route.view',
            'order' => 1
        ]);

        // Submenu
        DB::table('menus')->insert([
            [
                'parent_id' => $routeParent,
                'title' => 'Route List',
                'route' => 'admin.routes.index',
                'permission' => 'route.view',
                'order' => 1
            ],
        ]);

        // ============================
// TRIP MANAGEMENT
// ============================
        $tripGroup = DB::table('menu_groups')->insertGetId([
            'name' => 'Trip Management',
            'order' => 8
        ]);

        // Parent menu
        $tripParent = DB::table('menus')->insertGetId([
            'group_id' => $tripGroup,
            'title' => 'Trips',
            'icon' => 'ti-timer',
            'permission' => 'trip.view',
            'order' => 1
        ]);

        // Submenu
        DB::table('menus')->insert([
            [
                'parent_id' => $tripParent,
                'title' => 'Trip List',
                'route' => 'admin.trips.index',
                'permission' => 'trip.view',
                'order' => 1
            ],
        ]);
    }
}