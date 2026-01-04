<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\Route;
use App\Models\TripSeatStatus;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TripController extends Controller
{
    // Show index page
    public function index()
    {
        $routes = Route::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();
        $trips = Trip::with(['route', 'vehicle'])->latest()->get();

        return view('backend.pages.trips.index', compact('routes', 'vehicles', 'trips'));
    }

    // AJAX: Reload table
    public function list()
    {
        $trips = Trip::with(['route', 'vehicle'])->latest()->get();
        return view('backend.pages.trips.partials.table', compact('trips'))->render();
    }

    // Store new trip
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'nullable',
            'base_fare' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        Trip::create([
            'route_id' => $request->route_id,
            'vehicle_id' => $request->vehicle_id,
            'trip_code' => 'TRIP-' . now()->format('Ymd') . '-' . Str::random(4),
            'date' => $request->date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'base_fare' => $request->base_fare,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    // Load edit modal data
    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        return response()->json($trip);
    }

    // Update trip
    public function update(Request $request, $id)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'nullable',
            'base_fare' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        $trip = Trip::findOrFail($id);

        $trip->update([
            'route_id' => $request->route_id,
            'vehicle_id' => $request->vehicle_id,
            'date' => $request->date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'base_fare' => $request->base_fare,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    // Delete trip
    public function destroy($id)
    {
        Trip::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // Seat Mapping Page
    public function seatMapping($id)
    {
        $trip = Trip::with('vehicle')->findOrFail($id);

        // If mapping does not exist → auto generate
        if (!TripSeatStatus::where('trip_id', $id)->exists()) {

            $seats = Seat::where('vehicle_id', $trip->vehicle_id)->get();

            foreach ($seats as $seat) {
                TripSeatStatus::create([
                    'trip_id' => $trip->id,
                    'seat_id' => $seat->id,
                    'status' => 'available',
                    'fare' => $trip->base_fare * $seat->base_fare_multiplier,
                ]);
            }
        }

        // Load mapping
        $seats = TripSeatStatus::where('trip_id', $id)
            ->with('seat')
            ->get();

        return view('backend.pages.trips.seat-mapping', compact('trip', 'seats'));
    }

    // Update Seat Status (AJAX)
    public function updateSeatStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:available,booked,reserved,blocked'
            ]);

            // Find seat mapping row
            $seatMap = TripSeatStatus::findOrFail($id);

            // Update status
            $seatMap->status = $request->status;
            $seatMap->save();

            return response()->json([
                'success' => true,
                'message' => 'Seat status updated successfully',
                'status' => $seatMap->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}