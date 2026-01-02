<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            "payment_mode" => "required|string",
            "advancedAmount" => "required|numeric",
            "companyname" => "nullable|string|min:2|max:255",
            "usergst" => [
                "nullable",
                "regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/"
            ],
            "bookingDetails" => "required|array",
            "bookingDetails.bookingData" => "required|array",
            "bookingDetails.selectedCar" => "required|array",
        ]);

        // ✅ ALWAYS take correct object
        $details = $request->bookingDetails;
        $bookingData = $details["bookingData"];
        $car = $details["selectedCar"];
        $userid = $details["userId"];

        // Calculate distance based on trip type
        $distance = $this->calculateDistance($car);

        // Update user company info if provided
        $updateData = [];
        if ($request->filled('companyname')) {
            $updateData['companyname'] = $request->companyname;
        }
        if ($request->filled('usergst')) {
            $updateData['usergst'] = strtoupper($request->usergst);
        }
        if (!empty($updateData)) {
            User::where('id', $userid)->update($updateData);
        }

        // Payment Logic
        if ($request->advancedAmount == 0) {
            $paymentStatus = "pending";
            $paymentId = "PAY_LATER_" . Str::random(10);
        } else {
            $paymentStatus = "paid";
            $paymentId = $request->razorpay_payment_id ?? ("PAY_" . Str::random(10));
        }

        // ---------------- Booking Reference Generate (INLINE) ----------------
        $date = Carbon::now()->format('Ymd'); // 20251227

        DB::transaction(function () use (&$bookingReference, $date) {

            $lastBooking = Booking::whereDate('created_at', Carbon::today())
                ->where('booking_reference', 'like', "CRK-{$date}-%")
                ->lockForUpdate()
                ->latest('id')
                ->first();

            $lastNumber = $lastBooking
                ? (int) substr($lastBooking->booking_reference, -4)
                : 0;

            $bookingReference = "CRK-{$date}-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
        // --------------------------------------------------------------------

        // Save Booking
        $booking = Booking::create([
            "booking_reference" => $bookingReference,
            "user_id" => $userid,
            "vendor_id" => $car['vendor_id'] ?? null,
            "cab_id" => $car['cab_id'] ?? null,
            "package_id" => $car['package_id'] ?? null,
            "from_city_id" => $bookingData['from_city_id'] ?? $bookingData['city_id'] ?? null,
            "to_city_id" => $bookingData['to_city_id'] ?? null,
            "pickup_date" => $bookingData["pickupDate"],
            "pickup_time" => date("H:i:s", strtotime($bookingData["pickupTime"])),
            "pickup_address" => $details["pickup"],
            "drop_address" => $details["drop"],
            "distance_km" => $distance,
            "fare_without_gst" => $car["base_fare"],
            "total_estimated_fare" => $car["final_fare"],
            "booking_status" => "confirmed",
            "payment_status" => $paymentStatus,
            "payment_id" => $paymentId,
            "trip_type" => $car["trip_type"],
            'company_name' => $request->companyname,
            'gst_number' => $request->usergst,
        ]);

        // Get user data
        $user = User::findOrFail($userid);

        // Generate PDF invoice
        $pdf = $this->generateInvoicePDF($booking, $user, $car, $bookingData);

        // In the create method, update the email data preparation:
        // Prepare email data with proper subject formatting
        $tripType = ucfirst($car['trip_type']);
        $formattedDate = date('d M', strtotime($bookingData['pickupDate']));
        $fromLocation = $bookingData['fromLocation'] ?? $booking->fromCity->name ?? 'Location';
        $subject = "Your confirmed {$tripType} trip booking from {$fromLocation} on {$formattedDate} (ID: {$bookingReference})";


        // Prepare email data
        $mailData = [
            'booking' => $booking,
            'user' => $user,
            'subject' => $subject,
            'tripType' => $tripType,
            'formattedDate' => $formattedDate,
            'fromLocation' => $fromLocation,
            'toLocation' => $bookingData['toLocation'] ?? $booking->toCity->name ?? 'Destination',
            'pickupDate' => date('d M Y', strtotime($bookingData['pickupDate'])),
            'pickupTime' => date('g:i a', strtotime($bookingData['pickupTime'])),
            'carType' => $car['cab_name'] ?? 'Standard Car',
            'baseFare' => $car["base_fare"] ?? 0,
            'totalFare' => $car["final_fare"] ?? 0,
            'gstAmount' => round(($car["base_fare"] * 5) / 100, 2),
            'phoneLastFour' => substr($user->phone ?? '', -4), // Last 4 digits for privacy
        ];

        // Send confirmation email with custom subject
        Mail::to($user->email)->send(new BookingConfirmationMail($booking, $pdf, $mailData, $subject));

        return response()->json([
            "status" => "success",
            "message" => "Booking created and confirmation email sent",
            "booking_id" => $booking->id,
            "booking_reference" => $bookingReference,
            "payment_id" => $paymentId
        ]);
    }

    private function calculateDistance($car)
    {
        switch ($car["trip_type"]) {
            case 'oneway':
                return $car["distance_km"] ?? 0;
            case 'roundtrip':
                return ($car["distance_km"] ?? 0) * 2;
            case 'local':
            case 'airport':
                return $car["included_km"] ?? $car["distance_km"] ?? 0;
            case 'hourly':
                $hours = $car["included_hours"] ?? 0;
                return $hours * 40;
            default:
                return $car["distance_km"] ?? 0;
        }
    }

    private function generateInvoicePDF($booking, $user, $car = null, $bookingData = null)
    {
        // Calculate GST (assuming 5%)
        $gstAmount = round(($booking->fare_without_gst * 5) / 100, 2);
        
        // Calculate extra charges per km
        $extraChargePerKm = $car['extra_price_per_km']; // Default value
        
        // Get pickup and drop locations
        $fromLocation = $bookingData['fromLocation'] ?? ($booking->fromCity->name ?? 'N/A');
        $toLocation = $bookingData['toLocation'] ?? ($booking->toCity->name ?? 'N/A');
        
        // Format dates
        $pickupDateFormatted = date('d M Y', strtotime($booking->pickup_date));
        $pickupTimeFormatted = date('g:i a', strtotime($booking->pickup_time));
        
        $data = [
            'booking' => $booking,
            'user' => $user,
            'car' => $car ?? ['cab_name' => $booking->cab->cab_name ?? 'Standard Car'],
            'gstAmount' => $gstAmount,
            'extraChargePerKm' => $extraChargePerKm,
            'pickupDateFormatted' => $pickupDateFormatted,
            'pickupTimeFormatted' => $pickupTimeFormatted,
            'fromLocation' => $fromLocation,
            'toLocation' => $toLocation,
            'invoiceDate' => now()->format('d/m/Y'),
            'invoiceNumber' => 'INV-' . $booking->booking_reference
        ];

        return Pdf::loadView('pdf.travel-itinerary', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'Helvetica')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);
    }
    

    public function show($id)
    {
        try {
            $booking = $this->getBookingWithRelations($id);
            
            if (!$booking) {
                return response()->json([
                    "status" => "error",
                    "message" => "Booking not found"
                ], 404);
            }

            return response()->json([
                "status" => "success",
                "booking" => $booking
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch booking details",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    private function getBookingWithRelations($id)
    {
        return Booking::with([
                'user:id,name,email,phone',
                'cab:id,cab_name,cab_type,image,capacity,registration_no',
                'vendor:id,name,email,phone',
                'fromCity:id,name,state',
                'toCity:id,name,state',
                'package:id'
            ])
            ->find($id);
    }

    public function index(Request $request)
    {
        $query = Booking::query()->with(['user', 'cab', 'fromCity', 'toCity']);
        
        // Filter by user ID if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('pickup_date', [$request->start_date, $request->end_date]);
        }
        
        // Pagination
        $perPage = $request->get('per_page', 15);
        $bookings = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            "status" => "success",
            "data" => $bookings
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,ongoing,completed,cancelled',
            'cancellation_reason' => 'nullable|string|max:500'
        ]);

        $booking = Booking::find($id);
        
        if (!$booking) {
            return response()->json([
                "status" => "error",
                "message" => "Booking not found"
            ], 404);
        }

        $booking->status = $request->status;
        
        if ($request->has('cancellation_reason')) {
            $booking->cancellation_reason = $request->cancellation_reason;
        }
        
        $booking->save();

        return response()->json([
            "status" => "success",
            "message" => "Booking status updated successfully",
            "booking" => $this->getBookingWithRelations($booking->id)
        ]);
    }

    // Get user's bookings
    public function getUserBookings(Request $request, $userId)
    {
        try {
            $user = User::find($userId);
            
            if (!$user) {
                return response()->json([
                    "status" => "error",
                    "message" => "User not found"
                ], 404);
            }

            // Check authorization
            $authUser = $request->user();
            if (!$authUser || ($authUser->id != $userId && !$authUser->isAdmin())) {
                return response()->json([
                    "status" => "error",
                    "message" => "Unauthorized"
                ], 403);
            }

            $bookings = Booking::with([
                'cab:id,cab_name,cab_type,image,capacity,registration_no',
                'fromCity:id,name,state',
                'toCity:id,name,state',
                'package:id,name'
            ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

            return response()->json([
                "status" => "success",
                "bookings" => $bookings
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching user bookings: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch bookings"
            ], 500);
        }
    }

    // Cancel booking
    public function cancelBooking(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);
            
            if (!$booking) {
                return response()->json([
                    "status" => "error",
                    "message" => "Booking not found"
                ], 404);
            }

            // Check authorization
            $user = $request->user();
            if (!$user || ($booking->user_id != $user->id && !$user->isAdmin())) {
                return response()->json([
                    "status" => "error",
                    "message" => "Unauthorized"
                ], 403);
            }

            // Check if booking can be cancelled
            if (in_array($booking->status, ['cancelled', 'completed'])) {
                return response()->json([
                    "status" => "error",
                    "message" => "Cannot cancel this booking"
                ], 400);
            }

            // Update booking status
            $booking->status = 'cancelled';
            $booking->save();

            return response()->json([
                "status" => "success",
                "message" => "Booking cancelled successfully",
                "booking" => $booking
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error cancelling booking: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to cancel booking"
            ], 500);
        }
    }

    // Get booking details
    public function getBookingDetails($id)
    {
        try {
            $booking = Booking::with([
                'cab:id,cab_name,cab_type,image,capacity,registration_no',
                'fromCity:id,name,state',
                'toCity:id,name,state',
                'package:id,name'
            ])->find($id);
            
            if (!$booking) {
                return response()->json([
                    "status" => "error",
                    "message" => "Booking not found"
                ], 404);
            }

            return response()->json([
                "status" => "success",
                "booking" => $booking
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching booking: ' . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to fetch booking"
            ], 500);
        }
    }
      
}
