<?php

use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\MenuGroupController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RouteController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\TripController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\VehicleTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
// Login and Authentication Routes
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginAll'])->name('login.post');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Menu Management Routes

    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');

    Route::post('/menus/store', [MenuController::class, 'storeAjax'])->name('menus.store.ajax');
    Route::post('/menus/update/{id}', [MenuController::class, 'updateAjax'])->name('menus.update.ajax');
    Route::delete('/menus/delete/{id}', [MenuController::class, 'deleteAjax'])->name('menus.delete.ajax');

    // Menu Group Management Routes
    Route::get('/menu-groups', [MenuGroupController::class, 'index'])->name('menu-groups.index');

    Route::post('/menu-groups/store', [MenuGroupController::class, 'storeAjax'])->name('menu-groups.store.ajax');

    Route::post('/menu-groups/update/{id}', [MenuGroupController::class, 'updateAjax'])->name('menu-groups.update.ajax');

    Route::delete('/menu-groups/delete/{id}', [MenuGroupController::class, 'deleteAjax'])->name('menu-groups.delete.ajax');

    // Role Management Routes
    // Role Management Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    Route::post('/roles/store', [RoleController::class, 'storeAjax'])->name('roles.store.ajax');

    Route::post('/roles/update/{id}', [RoleController::class, 'updateAjax'])->name('roles.update.ajax');

    Route::delete('/roles/delete/{id}', [RoleController::class, 'deleteAjax'])->name('roles.delete.ajax');

    // FIXED: Correct method name
    Route::get('/roles/{id}/permissions', [RoleController::class, 'getRole']);

    // FIXED: Add missing method
    Route::post('/roles/{id}/permissions/update', [RoleController::class, 'updatePermissions']);

    // Permission Management
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

    Route::post('/permissions/store', [PermissionController::class, 'storeAjax'])->name('permissions.store.ajax');

    Route::post('/permissions/update/{id}', [PermissionController::class, 'updateAjax'])->name('permissions.update.ajax');

    Route::delete('/permissions/delete/{id}', [PermissionController::class, 'deleteAjax'])->name('permissions.delete.ajax');


    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/store', [UserController::class, 'storeAjax'])->name('users.store');
        Route::post('/update/{id}', [UserController::class, 'updateAjax'])->name('users.update');
        Route::delete('/delete/{id}', [UserController::class, 'deleteAjax'])->name('users.delete');

        // User Profile Route
        Route::get('/profile-modal/{id}', [UserController::class, 'profileModal'])
            ->name('users.profile.modal');

        // Edit Profile Modal
        Route::get('profile-edit-modal/{id}', [UserController::class, 'profileEditModal'])
            ->name('users.profile.edit.modal');

        // Update Profile (AJAX)
        Route::post('profile-update/{id}', [UserController::class, 'profileUpdate'])
            ->name('users.profile.update');
        // User List Route for AJAX Reload
        Route::get('list', [UserController::class, 'list'])->name('users.list');

    });

    // Vehicle Type Management
    Route::prefix('vehicle-types')->group(function () {

        Route::get('/', [VehicleTypeController::class, 'index'])
            ->name('vehicle.types.index');

        Route::post('/store', [VehicleTypeController::class, 'store'])
            ->name('vehicle.types.store');

        Route::get('/edit/{id}', [VehicleTypeController::class, 'edit'])
            ->name('vehicle.types.edit');

        Route::post('/update/{id}', [VehicleTypeController::class, 'update'])
            ->name('vehicle.types.update');

        Route::delete('/delete/{id}', [VehicleTypeController::class, 'destroy'])
            ->name('vehicle.types.delete');

        Route::get('/list', [VehicleTypeController::class, 'list'])
            ->name('vehicle.types.list');
    });

    // ============================
// VEHICLE MANAGEMENT
// ============================
    Route::prefix('vehicles')->name('vehicles.')->group(function () {

        // Index Page
        Route::get('/', [VehicleController::class, 'index'])
            ->name('index');

        // Store (AJAX)
        Route::post('/store', [VehicleController::class, 'store'])
            ->name('store');

        // Edit Modal Data Load (AJAX)
        Route::get('/edit/{id}', [VehicleController::class, 'edit'])
            ->name('edit');

        // Update (AJAX)
        Route::post('/update/{id}', [VehicleController::class, 'update'])
            ->name('update');

        // Delete (AJAX)
        Route::delete('/delete/{id}', [VehicleController::class, 'destroy'])
            ->name('delete');

        // List Reload (AJAX)
        Route::get('/list', [VehicleController::class, 'list'])
            ->name('list');
    });

    // ============================
// ROUTE MANAGEMENT
// ============================
    Route::prefix('routes')->name('routes.')->group(function () {

        // Index Page
        Route::get('/', [RouteController::class, 'index'])
            ->name('index');

        // Store (AJAX)
        Route::post('/store', [RouteController::class, 'store'])
            ->name('store');

        // Edit Modal Data Load (AJAX)
        Route::get('/edit/{id}', [RouteController::class, 'edit'])
            ->name('edit');

        // Update (AJAX)
        Route::post('/update/{id}', [RouteController::class, 'update'])
            ->name('update');

        // Delete (AJAX)
        Route::delete('/delete/{id}', [RouteController::class, 'destroy'])
            ->name('delete');

        // List Reload (AJAX)
        Route::get('/list', [RouteController::class, 'list'])
            ->name('list');
    });

    // ============================
// TRIP MANAGEMENT
// ============================
    Route::prefix('trips')->name('trips.')->group(function () {

        // Index Page
        Route::get('/', [TripController::class, 'index'])
            ->name('index');

        // Store (AJAX)
        Route::post('/store', [TripController::class, 'store'])
            ->name('store');

        // Edit Modal Data Load (AJAX)
        Route::get('/edit/{id}', [TripController::class, 'edit'])
            ->name('edit');

        // Update (AJAX)
        Route::post('/update/{id}', [TripController::class, 'update'])
            ->name('update');

        // Delete (AJAX)
        Route::delete('/delete/{id}', [TripController::class, 'destroy'])
            ->name('delete');

        // List Reload (AJAX)
        Route::get('/list', [TripController::class, 'list'])
            ->name('list');
        // ⭐ NEW: Trip Seat Mapping Page
        Route::get('/{id}/seats', [TripController::class, 'seatMapping'])
            ->name('seats.mapping');

        // ⭐ NEW: Update Seat Status (AJAX)
        Route::post('/seat-status/update/{id}', [TripController::class, 'updateSeatStatus'])
            ->name('seat.status.update');

    });
    // ============================
// SEAT MANAGEMENT
// ============================
    Route::prefix('seats')->name('seats.')->group(function () {

        // Index Page
        Route::get('/', [SeatController::class, 'index'])
            ->name('index');

        // Store (AJAX)
        Route::post('/store', [SeatController::class, 'store'])
            ->name('store');

        // Edit Modal Data Load (AJAX)
        Route::get('/edit/{id}', [SeatController::class, 'edit'])
            ->name('edit');

        // Update (AJAX)
        Route::post('/update/{id}', [SeatController::class, 'update'])
            ->name('update');

        // Delete (AJAX)
        Route::delete('/delete/{id}', [SeatController::class, 'destroy'])
            ->name('delete');

        // List Reload (AJAX)
        Route::get('/list', [SeatController::class, 'list'])
            ->name('list');
    });

    // ============================
// BOOKING MANAGEMENT

    Route::prefix('bookings')->name('bookings.')->group(function () {

        // Index Page
        Route::get('/', [BookingController::class, 'index'])
            ->name('index');

        // List Reload (AJAX)
        Route::get('/list', [BookingController::class, 'list'])
            ->name('list');

        // Store (AJAX)
        Route::post('/store', [BookingController::class, 'store'])
            ->name('store');

        // Edit Modal Load (AJAX)
        Route::get('/edit/{id}', [BookingController::class, 'edit'])
            ->name('edit');

        // Update (AJAX)
        Route::post('/update/{id}', [BookingController::class, 'update'])
            ->name('update');

        // Delete (AJAX)
        Route::delete('/delete/{id}', [BookingController::class, 'destroy'])
            ->name('delete');

        // Seat List for Trip (AJAX)
        Route::get('/seat-list/{tripId}', [BookingController::class, 'seatList'])
            ->name('seat.list');

        // Show Modal (AJAX)
        Route::get('/show/{id}', [BookingController::class, 'show'])
            ->name('show');

        // Cancel Booking Routes
        Route::get('/cancel-info/{id}', [BookingController::class, 'cancelInfo'])->name('cancel.info');
        Route::post('/cancel/{id}', [BookingController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('settings')->name('settings.')->group(function () {

        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/store', [SettingController::class, 'store'])->name('store');
        // AJAX update single setting
        Route::post('/update', [SettingController::class, 'update'])->name('update');

        // (optional) AJAX list reload
        Route::get('/list', [SettingController::class, 'list'])->name('list');
    });
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('test', function () {
        return 'Test Successful';
    })->name('test');
});

