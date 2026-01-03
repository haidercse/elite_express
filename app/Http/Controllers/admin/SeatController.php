<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    // Show index page
    public function index()
    {
        $vehicles = Vehicle::where('status', 'active')->get();
        $seats = Seat::with('vehicle')->latest()->get();

        return view('backend.pages.seats.index', compact('vehicles', 'seats'));
    }

    // AJAX: Reload table
    public function list()
    {
        $seats = Seat::with('vehicle')->latest()->get();
        return view('backend.pages.seats.partials.table', compact('seats'))->render();
    }

    // Store new seat
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'seat_number' => 'required|string|max:20',
            'seat_type' => 'required|in:front,middle,back,window,aisle,driver',
            'seat_category' => 'required|in:vip,regular,economy',
            'base_fare_multiplier' => 'required|numeric|min:0',
            'position_row' => 'nullable|integer|min:1',
            'position_column' => 'nullable|integer|min:1',
        ]);

        Seat::create($request->all());

        return response()->json(['success' => true]);
    }

    // Load edit modal data
    public function edit($id)
    {
        $seat = Seat::findOrFail($id);
        return response()->json($seat);
    }

    // Update seat
    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'seat_number' => 'required|string|max:20',
            'seat_type' => 'required|in:front,middle,back,window,aisle,driver',
            'seat_category' => 'required|in:vip,regular,economy',
            'base_fare_multiplier' => 'required|numeric|min:0',
            'position_row' => 'nullable|integer|min:1',
            'position_column' => 'nullable|integer|min:1',
        ]);

        $seat = Seat::findOrFail($id);
        $seat->update($request->all());

        return response()->json(['success' => true]);
    }

    // Delete seat
    public function destroy($id)
    {
        Seat::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}