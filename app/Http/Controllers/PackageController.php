<?php
namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Vendor;
use App\Models\Cab;
use App\Models\TripType;
use App\Models\City;
use App\Models\Airport;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['vendor', 'cab', 'tripType', 'fromCity', 'toCity', 'airport'])->latest()->get();
        return view('packages.index', compact('packages'));
    }

    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }

    public function create()
    {
        return view('packages.create', [
            'vendors' => Vendor::where('status', 'active')->get(),
            'cabs' => Cab::where('status', 'active')->get(),
            'tripTypes' => TripType::all(),
            'cities' => City::all(),
            'airports' => Airport::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'cab_id' => 'required|exists:cabs,id',
            'trip_type_id' => 'required|exists:trip_types,id',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'nullable|exists:cities,id',

            // pricing fields
            'offer_price' => 'required|numeric',
            'price_per_km' => 'required|numeric',
            'extra_price_per_km' => 'nullable|numeric',
            'da' => 'nullable|numeric',
            'toll_tax' => 'nullable|numeric',
            'gst' => 'nullable|numeric',

            // new fields
            'hours' => 'nullable|integer|min:0',
            'kms' => 'nullable|integer|min:0',

            // airport + status
            'airport_type' => 'nullable|string|in:pickup,drop',
            'airport_id' => 'nullable|exists:airports,id',
            'status' => 'required|in:active,inactive',
            'airport_min_km'=>'nullable|numeric',
        ]);

        // ✅ prevent duplicate config
        $exists = Package::where([
            'vendor_id' => $validated['vendor_id'],
            'cab_id' => $validated['cab_id'],
            'trip_type_id' => $validated['trip_type_id'],
            'from_city_id' => $validated['from_city_id'],
            'to_city_id' => $validated['to_city_id'],
            'hours' => $validated['hours'] ?? null,
            'kms' => $validated['kms'] ?? null,
            'airport_type'=> $validated['airport_type'],
            'airport_id'=> $validated['airport_id'],
        ])->exists();

        if ($exists) {
            return redirect()->route('packages.index')
                ->withInput()
                ->with('error', 'Package with this configuration already exists!');
        }

        Package::create($validated);

        return redirect()->route('packages.index')->with('success', 'Package added successfully.');
    }

    // public function edit(Package $package)
    // {
    //     return view('packages.edit', [
    //         'package' => $package,
    //         'vendors' => Vendor::where('status', 'active')->get(),
    //         'cabs' => Cab::where('status', 'active')->get(),
    //         'tripTypes' => TripType::all(),
    //         'cities' => City::all(),
    //         'airports' => Airport::all(),
    //     ]);
    // }

    // PackageController mein edit method
    public function edit(Package $package)
        {
            $vendors = Vendor::where('status', 'active')->get();
            $tripTypes = TripType::all();
            $cities = City::all();
            $airports = Airport::all();
            
            // Current vendor ki cabs load karo (optional - agar initial state mein show karna ho)
            $currentVendorCabs = Cab::where('vendor_id', $package->vendor_id)
                                ->where('status', 'active')
                                ->get();

            return view('packages.edit', compact(
                'package', 
                'vendors', 
                'tripTypes', 
                'cities', 
                'airports',
                'currentVendorCabs'
            ));
        }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'cab_id' => 'required|exists:cabs,id',
            'trip_type_id' => 'required|exists:trip_types,id',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'nullable|exists:cities,id',

            // pricing fields
            'offer_price' => 'required|numeric',
            'price_per_km' => 'required|numeric',
            'extra_price_per_km' => 'nullable|numeric',
            'da' => 'nullable|numeric',
            'toll_tax' => 'nullable|numeric',
            'gst' => 'nullable|numeric',

            // new fields
            'hours' => 'nullable|integer|min:0',
            'kms' => 'nullable|integer|min:0',

            // airport + status
            'airport_type' => 'nullable|string|in:pickup,drop',
            'airport_id' => 'nullable|exists:airports,id',
            'status' => 'required|in:active,inactive',
            'airport_min_km'=>'nullable|numeric',
        ]);

        $package->update($validated);

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');
    }

    // In your PackageController or separate Controller
    public function getVendorCabs(Request $request)
    {
        try {
            $vendorId = $request->vendor_id;
            
            $cabs = Cab::where('vendor_id', $vendorId)
                    ->where('status', 'active')
                    ->select('id', 'cab_name', 'cab_type')
                    ->get();
            
            return response()->json([
                'success' => true,
                'cabs' => $cabs
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cabs'
            ], 500);
        }
    }
}
