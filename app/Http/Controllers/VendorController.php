<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
        return view('vendors.index', compact('vendors'));
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:vendors,email',
            'phone' => 'nullable|string|max:15|unique:vendors,phone',
            'logo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'email.unique' => 'This email is already registered for another vendor.',
            'phone.unique' => 'This phone number is already registered for another vendor.',
        ]);

        // Ensure at least one contact (email or phone)
        if (!$request->email && !$request->phone) {
            return back()->withErrors(['email' => 'Either email or phone is required.'])->withInput();
        }

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('vendors', 'public');
        }

        Vendor::create($data);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor added successfully!');
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:15|unique:vendors,phone,' . $vendor->id,
            'logo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'city_id' => 'nullable|exists:cities,id',
        ], [
            'email.unique' => 'This email is already registered for another vendor.',
            'phone.unique' => 'This phone number is already registered for another vendor.',
        ]);

        if (!$request->email && !$request->phone) {
            return back()->withErrors(['email' => 'Either email or phone is required.'])->withInput();
        }

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('vendors', 'public');
        }

        $vendor->update($data);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor updated successfully!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor deleted successfully!');
    }
}
