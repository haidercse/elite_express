<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleTypeRequest;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $types = VehicleType::latest()->get();
        return view('backend.pages.vehicle_types.index', compact('types'));
    }

    public function store(StoreVehicleTypeRequest $request)
    {
        VehicleType::create($request->validated());
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $type = VehicleType::findOrFail($id);
        return response()->json($type);
    }

    public function update(StoreVehicleTypeRequest $request, $id)
    {
        $type = VehicleType::findOrFail($id);
        $type->update($request->validated());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        VehicleType::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // ⭐ THIS WAS MISSING — Added now
    public function list()
    {
        $types = VehicleType::latest()->get();
        return view('backend.pages.vehicle_types.partials.table', compact('types'))->render();
    }
}