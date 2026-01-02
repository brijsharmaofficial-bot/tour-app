<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
        ]);

        City::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'City added successfully.');
    }

    public function index()
    {
        $cities = City::latest()->get();
        return view('cities.index', compact('cities'));
    }
    public function edit(City $city)
    {
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
        ]);

        $city->update(['name' => $request->name]);

        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }

}
