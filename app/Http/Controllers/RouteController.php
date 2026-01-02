<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\City;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Show all routes
    public function index()
    {
        $routes = Route::with(['fromCity', 'toCity'])->orderBy('id', 'desc')->get();
        return view('routes.index', compact('routes'));
    }

    // Show form to create a route
    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('routes.create', compact('cities'));
    }

    // Store new route
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_city_id' => 'required|exists:cities,id|different:to_city_id',
            'to_city_id'   => 'required|exists:cities,id',
            'distance_km'  => 'required|numeric|min:0',
            'approx_time'  => 'nullable|string|max:50',
            'toll_tax'     => 'nullable|numeric|min:0',
            'status'       => 'required|in:active,inactive',
        ]);

        Route::create($validated);

        return redirect()->route('routes.index')->with('success', 'Route added successfully!');
    }

    // Show edit form
    public function edit(Route $route)
    {
        $cities = City::orderBy('name')->get();
        return view('routes.edit', compact('route', 'cities'));
    }

    // Update route
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'from_city_id' => 'required|exists:cities,id|different:to_city_id',
            'to_city_id'   => 'required|exists:cities,id',
            'distance_km'  => 'required|numeric|min:0',
            'approx_time'  => 'nullable|string|max:50',
            'toll_tax'     => 'nullable|numeric|min:0',
            'status'       => 'required|in:active,inactive',
        ]);

        $route->update($validated);

        return redirect()->route('routes.index')->with('success', 'Route updated successfully!');
    }

    // Delete route
    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index')->with('success', 'Route deleted successfully!');
    }
}
