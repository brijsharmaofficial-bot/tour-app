<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Cab;
use App\Models\Package;
use App\Models\City;
use App\Models\Route;
use App\Models\Airport;
use App\Models\CompanyDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Display all bookings
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'vendor', 'cab', 'fromCity', 'toCity'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking creation form
     */
    public function create()
    {
        return view('bookings.create', [
            'users'     => User::where('role', 'customer')->get(),
            'vendors'   => Vendor::where('status', 'active')->get(),
            'cabs'      => Cab::where('status', 'active')->get(),
            'packages'  => Package::with(['tripType', 'fromCity', 'toCity'])
                ->where('status', 'active')
                ->get(),
            'cities'    => City::all(),
            'airports'  => Airport::where('status', 'active')->with('city')->get(),
        ]);
    }

    /**
     * Store new booking
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'user_id'              => 'required|exists:users,id',
            'vendor_id'            => 'nullable|exists:vendors,id',
            'cab_id'               => 'nullable|exists:cabs,id',
            'package_id'           => 'required|exists:packages,id',
            'from_city_id'         => 'required|exists:cities,id',
            'to_city_id'           => 'nullable|exists:cities,id',
            'pickup_date'          => 'required|date',
            'pickup_time'          => 'required',
            'pickup_address'       => 'required|string|max:255',
            'drop_address'         => 'nullable|string|max:255',
            'distance_km'          => 'nullable|numeric|min:0',
            'fare_without_gst'     => 'nullable|numeric|min:0',
            'total_estimated_fare' => 'required|numeric|min:0',
            'status'               => 'required|in:pending,assigned,in_progress,completed,cancelled',
            'payment_status'       => 'required|in:unpaid,paid',
        ]);
        

        Booking::create($request->all());

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking)
    {
        
        // $booking->load(['user', 'vendor', 'cab', 'package', 'fromCity', 'toCity']);
        // return view('bookings.show', compact('booking'));

        {
            $booking->load([
                'user',
                'vendor',
                'cab',
                'package',
                'fromCity',
                'toCity'
            ]);

            // Get available vendors and cabs for assignment
            $vendors = Vendor::where('status', 'active')->get();
            $cabs = Cab::where('status', 'active')->get();

            return view('bookings.show', compact('booking', 'vendors', 'cabs'));
        }
    }

    /**
     * Edit booking
     */
    public function edit(Booking $booking)
    {
        return view('bookings.edit', [
            'booking'  => $booking,
            'users'    => User::all(),
            'vendors'  => Vendor::where('status', 'active')->get(),
            'cabs'     => Cab::where('status', 'active')->get(),
            'packages' => Package::with(['tripType', 'fromCity', 'toCity'])
                ->where('status', 'active')
                ->get(),
            'cities'   => City::all(),
            'airports' => Airport::where('status', 'active')->with('city')->get(),
        ]);
    }

    /**
     * Update booking
     */
    public function update(Request $request, Booking $booking)
    {

        $request->validate([
            'user_id'              => 'required|exists:users,id',
            'vendor_id'            => 'nullable|exists:vendors,id',
            'cab_id'               => 'nullable|exists:cabs,id',
            'package_id'           => 'required|exists:packages,id',
            'from_city_id'         => 'required|exists:cities,id',
            'to_city_id'           => 'nullable|exists:cities,id',
            'pickup_date'          => 'required|date',
            'pickup_time'          => 'required',
            'pickup_address'       => 'required|string|max:255',
            'drop_address'         => 'nullable|string|max:255',
            'distance_km'          => 'nullable|numeric|min:0',
            'fare_without_gst'     => 'nullable|numeric|min:0',
            'total_estimated_fare' => 'required|numeric|min:0',
            'status'               => 'required|in:pending,assigned,in_progress,completed,cancelled',
            'payment_status'       => 'required|in:unpaid,paid',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Delete booking
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * Assign vendor & cab
     */
    public function assignVendor(Request $request, Booking $booking)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'cab_id'    => 'required|exists:cabs,id',
        ]);

        $booking->update([
            'vendor_id' => $request->vendor_id,
            'cab_id'    => $request->cab_id,
            'status'    => 'assigned',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Vendor and Cab assigned successfully.');
    }

    /**
     * Generate invoice
     */
    public function invoice(Booking $booking)
    {
        // $booking->load(['user', 'vendor', 'cab', 'package', 'fromCity', 'toCity']);
        // return view('bookings.invoice', compact('booking'));

        $booking->load(['user', 'vendor', 'cab', 'package.tripType', 'fromCity', 'toCity']);
        // Fetch company info (you can later make multiple records if needed)
        $company = CompanyDetail::latest()->first();
    
        return view('bookings.invoice', compact('booking', 'company'));
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $packages = Package::with(['tripType','fromCity','toCity'])
            ->whereHas('fromCity', fn($c)=>$c->where('name','like',"%$q%"))
            ->orWhereHas('toCity', fn($c)=>$c->where('name','like',"%$q%"))
            ->orWhereHas('tripType', fn($t)=>$t->where('name','like',"%$q%"))
            ->limit(10)
            ->get()
            ->map(fn($p)=>[
                'id'=>$p->id,
                'trip_type_name'=>$p->tripType->name ?? '',
                'from_city_name'=>$p->fromCity->name ?? '',
                'to_city_name'=>$p->toCity->name ?? ''
            ]);
        return response()->json($packages);
    }

    /**
     * 🔹 Fetch route distance dynamically
     */
    public function getDistance(Request $request)
    {
        $route = Route::where('from_city_id', $request->from_city_id)
            ->where('to_city_id', $request->to_city_id)
            ->first();

        return response()->json([
            'distance' => $route->distance_km ?? 0,
        ]);
    }

    /**
     * 🔹 Fetch cabs for selected vendor
     */
    public function getCabs(Request $request)
    {
        $cabs = Cab::where('vendor_id', $request->vendor_id)
            ->where('status', 'active')
            ->get(['id', 'cab_name', 'cab_type']);

        return response()->json($cabs);
    }

    /**
     * 🔹 Fetch package details and pricing
     */
    public function getPackage(Request $request)
    {
        $pkg = Package::with(['tripType', 'fromCity', 'toCity'])
            ->find($request->package_id);

        if (!$pkg) {
            return response()->json(['success' => false, 'message' => 'Package not found']);
        }

        return response()->json([
            'success' => true,
            'package' => [
                'id'                 => $pkg->id,
                'trip_type'          => strtolower($pkg->tripType->name ?? ''),
                'from_city'          => $pkg->fromCity->name ?? null,
                'to_city'            => $pkg->toCity->name ?? null,
                'base_price'         => (float) $pkg->base_price,
                'price_per_km'       => (float) $pkg->price_per_km,
                'extra_price_per_km' => (float) $pkg->extra_price_per_km,
                'gst'                => (float) $pkg->gst,
                'da'                 => (float) $pkg->da,
                'toll_tax'           => (float) $pkg->toll_tax,
                'hours'              => (float) $pkg->hours,
                'kms'                => (float) $pkg->kms,
                'price'              => (float) $pkg->price, // local fixed price
            ]
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
{
    $request->validate([
        'status' => 'required|in:pending,assigned,in_progress,completed,cancelled'
    ]);

    $booking->update([
        'status' => $request->status,
        'status_updated_at' => now()
    ]);

    return redirect()->back()->with('success', 'Booking status updated successfully!');
}

public function updatePaymentStatus(Request $request, Booking $booking)
{
    $request->validate([
        'payment_status' => 'required|in:pending,paid,failed,refunded'
    ]);

    $booking->update([
        'payment_status' => $request->payment_status,
        'paid_at' => $request->payment_status == 'paid' ? now() : null
    ]);

    return redirect()->back()->with('success', 'Payment status updated successfully!');
}

// public function assignVendor(Request $request, Booking $booking)
// {
//     $request->validate([
//         'vendor_id' => 'required|exists:vendors,id',
//         'cab_id' => 'required|exists:cabs,id',
//         'driver_notes' => 'nullable|string'
//     ]);

//     $booking->update([
//         'vendor_id' => $request->vendor_id,
//         'cab_id' => $request->cab_id,
//         'driver_notes' => $request->driver_notes,
//         'status' => 'assigned',
//         'assigned_at' => now()
//     ]);

//     return redirect()->back()->with('success', 'Vendor assigned successfully!');
// }

public function sendNotification(Request $request, Booking $booking)
{
    $request->validate([
        'notification_type' => 'required|string',
        'message' => 'required|string'
    ]);

    // Implement your notification logic here
    // This could be email, SMS, push notification, etc.

    return redirect()->back()->with('success', 'Notification sent successfully!');
}

}
