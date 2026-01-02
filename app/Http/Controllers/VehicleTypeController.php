<?php
namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::latest()->get();
        return view('vehicle_types.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('vehicle_types.create');
    }

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'rate_per_km' => 'nullable|numeric',
            'rate_per_max_km' => 'nullable|numeric',
        ]);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('icons'), $filename);
            $iconPath = 'icons/' . $filename;
        } else {
            $iconPath = null;
        }

        VehicleType::create([
            'name' => $request->name,
            'icon' => $iconPath,
            'rate_per_km' => $request->rate_per_km,
            'rate_per_max_km' => $request->rate_per_max_km,
        ]);

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type created successfully.');
    }


    public function edit(VehicleType $vehicleType)
    {
        return view('vehicle_types.edit', compact('vehicleType'));
    }

  public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'name' => 'required|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'rate_per_km' => 'nullable|numeric',
            'rate_per_max_km' => 'nullable|numeric',
        ]);

        $data = $request->only('name','rate_per_km', 'rate_per_max_km');

        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($vehicleType->icon && file_exists(public_path($vehicleType->icon))) {
                unlink(public_path($vehicleType->icon));
            }

            $file = $request->file('icon');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('icons'), $filename);
            $data['icon'] = 'icons/' . $filename;
        }

        $vehicleType->update($data);

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type updated successfully.');
    }


    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        return redirect()->route('vehicle-types.index')->with('success', 'Vehicle type deleted successfully.');
    }
}
