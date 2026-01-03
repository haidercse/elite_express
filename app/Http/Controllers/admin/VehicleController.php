<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use App\Models\VehicleType;

class VehicleController extends Controller
{
    // Show index page
    public function index()
    {
        $vehicles = Vehicle::with('type')->latest()->get();
        $types = VehicleType::all();

        return view('backend.pages.vehicles.index', compact('vehicles', 'types'));
    }

    // AJAX: Reload table
    public function list()
    {
        $vehicles = Vehicle::with('type')->latest()->get();

        return view('backend.pages.vehicles.partials.table', compact('vehicles'))->render();
    }

    // Store new vehicle
    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create($request->validated());

        return response()->json(['success' => true]);
    }

    // Load edit modal data
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return response()->json($vehicle);
    }

    // Update vehicle
    public function update(StoreVehicleRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->validated());

        return response()->json(['success' => true]);
    }

    // Delete vehicle
    public function destroy($id)
    {
        Vehicle::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}