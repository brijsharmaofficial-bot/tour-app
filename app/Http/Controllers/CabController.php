<?php

namespace App\Http\Controllers;

use App\Models\Cab;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CabController extends Controller
{
    public function index()
    {
        $cabs = Cab::with('vendor')->latest()->get();
        return view('cabs.index', compact('cabs'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', 'active')->get();
        return view('cabs.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'cab_name' => 'required|string|max:255',
            'registration_no' => 'required|string|unique:cabs,registration_no',
            'cab_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // ✅ Handle Image Upload Properly
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cabs', 'public');
        }

        Cab::create($validated);

        return redirect()->route('cabs.index')->with('success', 'Cab added successfully.');
    }

    public function show(Cab $cab)
    {
        return view('cabs.show', compact('cab'));
    }

    public function edit(Cab $cab)
    {
        $vendors = Vendor::where('status', 'active')->get();
        return view('cabs.edit', compact('cab', 'vendors'));
    }

    public function update(Request $request, Cab $cab)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'cab_name' => 'required|string|max:255',
            'registration_no' => 'required|string|unique:cabs,registration_no,' . $cab->id,
            'cab_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
    
        // ✅ Handle new upload or preserve old image
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($cab->image && Storage::disk('public')->exists($cab->image)) {
                Storage::disk('public')->delete($cab->image);
            }
            $validated['image'] = $request->file('image')->store('cabs', 'public');
        } else {
            // preserve existing image if no new file uploaded
            $validated['image'] = $cab->image;
        }
    
        $cab->update($validated);
    
        return redirect()->route('cabs.index')->with('success', 'Cab updated successfully!');
    }
    

    public function destroy(Cab $cab)
    {
        if ($cab->image && Storage::disk('public')->exists($cab->image)) {
            Storage::disk('public')->delete($cab->image);
        }

        $cab->delete();

        return redirect()->route('cabs.index')->with('success', 'Cab deleted successfully.');
    }
}
