<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::with('vendor')->latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        $vendors = Vendor::all();
        return view('vehicles.create', compact('vendors'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id'        => 'required|exists:vendors,id',
            'vehicle_type'     => 'required|string|max:50',
            'vehicle_number'   => 'required|string|max:20|unique:vehicles',
            'license_number'   => 'required|string|max:50|unique:vehicles',
            'license_expiry'   => 'nullable|date',
            'insurance_number' => 'nullable|string|max:50|unique:vehicles',
            'insurance_expiry' => 'nullable|date',
            'vehicle_color'    => 'nullable|string|max:50',
            'vehicle_model'    => 'nullable|string|max:100',
            'vehicle_year'     => 'nullable|integer',
            'vehicle_documents'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle vehicle documents upload
        if ($request->hasFile('vehicle_documents')) {
            $validated['vehicle_documents'] = $request->file('vehicle_documents')->store('vehicle_docs', 'public');
        }

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Vehicle $vehicle)
    {
        $vendors = Vendor::all();
        return view('vehicles.edit', compact('vehicle', 'vendors'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'vendor_id'        => 'required|exists:vendors,id',
            'vehicle_type'     => 'required|string|max:50',
            'vehicle_number'   => 'required|string|max:20|unique:vehicles,vehicle_number,' . $vehicle->id,
            'license_number'   => 'required|string|max:50|unique:vehicles,license_number,' . $vehicle->id,
            'license_expiry'   => 'nullable|date',
            'insurance_number' => 'nullable|string|max:50|unique:vehicles,insurance_number,' . $vehicle->id,
            'insurance_expiry' => 'nullable|date',
            'vehicle_color'    => 'nullable|string|max:50',
            'vehicle_model'    => 'nullable|string|max:100',
            'vehicle_year'     => 'nullable|integer',
            'vehicle_documents'=> 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('vehicle_documents')) {
            $validated['vehicle_documents'] = $request->file('vehicle_documents')->store('vehicle_docs', 'public');
        }

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
