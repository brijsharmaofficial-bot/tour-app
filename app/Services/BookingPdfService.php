<?php

namespace App\Services;

use PDF;
use Carbon\Carbon;

class BookingPdfService
{
    public function generateBookingItinerary($bookingData)
    {
        // Format dates
        $pickupDate = Carbon::parse($bookingData['pickup_date'])->format('d M Y');
        $pickupDateTime = Carbon::parse($bookingData['pickup_date'] . ' ' . $bookingData['pickup_time'])->format('g:i a, d M Y');
        
        // Calculate GST (assuming 5% for simplicity)
        $baseFare = $bookingData['fare_without_gst'] ?? $bookingData['total_estimated_fare'] * 0.95;
        $gstAmount = $bookingData['total_estimated_fare'] - $baseFare;
        
        // Generate PDF
        $pdf = PDF::loadView('emails.booking-itinerary', [
            'booking' => $bookingData,
            'pickupDate' => $pickupDate,
            'pickupDateTime' => $pickupDateTime,
            'baseFare' => $baseFare,
            'gstAmount' => $gstAmount,
            'company' => [
                'name' => 'Car Rental Kolkata',
                'phone' => '+91 99999 99999',
                'email' => 'support@carrentalkolkata.com',
                'website' => 'https://carrentalkolkata.com'
            ]
        ]);
        
        // Set PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'helvetica',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        return $pdf;
    }
    
    public function generateBookingId()
    {
        $prefix = 'CRK';
        $date = date('ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        return $prefix . '-' . $date . '-' . $random;
    }
    
    public function getTripTypeDisplay($tripType)
    {
        $tripTypes = [
            'oneway' => 'One-way drop',
            'one-way' => 'One-way drop',
            'roundtrip' => 'Round Trip',
            'round-trip' => 'Round Trip',
            'local' => 'Local Package',
            'airport' => 'Airport Transfer',
            'hourly' => 'Hourly Rental',
        ];
        
        return $tripTypes[strtolower($tripType)] ?? 'One-way drop';
    }
}