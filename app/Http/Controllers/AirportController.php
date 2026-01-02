<?php
namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::with('city')->latest()->paginate(10);
        return view('airports.index', compact('airports'));
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('airports.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:active,inactive'
        ]);

        Airport::create($request->all());
        return redirect()->route('airports.index')->with('success', 'Airport added successfully.');
    }

    public function show(Airport $airport)
    {
        return view('airports.show', compact('airport'));
    }

    public function edit(Airport $airport)
    {
        $cities = City::orderBy('name')->get();
        return view('airports.edit', compact('airport', 'cities'));
    }

    public function update(Request $request, Airport $airport)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:active,inactive'
        ]);

        $airport->update($request->all());
        return redirect()->route('airports.index')->with('success', 'Airport updated successfully.');
    }

    public function destroy(Airport $airport)
    {
        $airport->delete();
        return redirect()->route('airports.index')->with('success', 'Airport deleted successfully.');
    }
}

?>