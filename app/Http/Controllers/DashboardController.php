<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Cab;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorsCount = Vendor::count();
        $cabsCount = Cab::count();
        $usersCount = User::count();
        $bookingsCount = Booking::count();

        $bookingStatusCounts = [
            Booking::where('status', 'pending')->count(),
            Booking::where('status', 'assigned')->count(),
            Booking::where('status', 'completed')->count(),
            Booking::where('status', 'cancelled')->count(),
        ];

        $recentBookings = Booking::with(['user','fromCity','toCity'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'vendorsCount', 'cabsCount', 'usersCount', 'bookingsCount',
            'bookingStatusCounts', 'recentBookings'
        ));
    }
}

