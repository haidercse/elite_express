<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Show index page
    public function index()
    {
        $routes = Route::latest()->get();
        return view('backend.pages.routes.index', compact('routes'));
    }

    // AJAX: Reload table
    public function list()
    {
        $routes = Route::latest()->get();
        return view('backend.pages.routes.partials.table', compact('routes'))->render();
    }

    // Store new route
    public function store(Request $request)
    {
        $request->validate([
            'from_city' => 'required|string|max:255',
            'to_city' => 'required|string|max:255',
            'distance_km' => 'nullable|integer|min:1',
            'approx_duration_minutes' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Route::create([
            'from_city' => $request->from_city,
            'to_city' => $request->to_city,
            'distance_km' => $request->distance_km,
            'approx_duration_minutes' => $request->approx_duration_minutes,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    // Load edit modal data
    public function edit($id)
    {
        $route = Route::findOrFail($id);
        return response()->json($route);
    }

    // Update route
    public function update(Request $request, $id)
    {
        $request->validate([
            'from_city' => 'required|string|max:255',
            'to_city' => 'required|string|max:255',
            'distance_km' => 'nullable|integer|min:1',
            'approx_duration_minutes' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $route = Route::findOrFail($id);

        $route->update([
            'from_city' => $request->from_city,
            'to_city' => $request->to_city,
            'distance_km' => $request->distance_km,
            'approx_duration_minutes' => $request->approx_duration_minutes,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    // Delete route
    public function destroy($id)
    {
        Route::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}