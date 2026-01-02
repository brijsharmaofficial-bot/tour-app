<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\TripType;
use App\Models\Route; // ✅ Import Route model

class SearchCabController extends Controller
{

    //demo
    public function searchCabs(Request $request)
    {
        $request->validate([
            'from_city_id' => 'required|integer',
            'to_city_id' => 'nullable|integer',
            'trip_type' => 'required|string',       
        ]);

        // ✅ Find trip type
        $tripType = TripType::where('name', $request->trip_type)->first();
        if (!$tripType) {
            return response()->json(['message' => 'Invalid trip type'], 400);
        }

        // ✅ Get distance from routes table (if available)
        $distance = null;
        if (!empty($request->to_city_id)) {
            $route = Route::where('from_city_id', $request->from_city_id)
                ->where('to_city_id', $request->to_city_id)
                ->first();

            if ($route) {
                $distance = $route->distance_km;
            }
        }

        // ✅ Fetch matching packages
        $query = Package::with(['vendor', 'cab', 'fromCity', 'toCity', 'tripType'])
            ->where('trip_type_id', $tripType->id)
            ->where('from_city_id', $request->from_city_id);

        if (in_array($request->trip_type, ['oneway', 'roundtrip']) && $request->to_city_id) {
            $query->where('to_city_id', $request->to_city_id);
        }

        $packages = $query->get();

        if ($packages->isEmpty()) {
            return response()->json(['message' => 'No cabs available for your route'], 404);
        }

        // ✅ Prepare response with distance and estimated fare
        $result = $packages->map(function ($pkg) use ($distance) {
            // calculate estimated fare if distance is available
            $estimated_fare = null;
            if ($distance && $pkg->price_per_km) {
                $estimated_fare = $pkg->base_price + ($pkg->price_per_km * $distance);
            }

            return [
                'package_id'     => $pkg->id,
                'trip_type'      => $pkg->tripType->name ?? null,
                'vendor'         => $pkg->vendor->name ?? null,
                'cab_name'       => $pkg->cab->cab_name ?? null,
                'cab_type'       => $pkg->cab->cab_type ?? null,
                'capacity'       => $pkg->cab->capacity ?? null,
                'distance_km'    => $distance ? $distance . ' km' : 'N/A',
                'base_price'     => $pkg->base_price,
                'price_per_km'   => $pkg->price_per_km,
                'estimated_fare' => $estimated_fare ? round($estimated_fare, 2) : 'N/A',
                'gst'            => $pkg->gst,
                'image'          => $pkg->cab->image ? asset('storage/' . $pkg->cab->image) : null
            ];
        });

        return response()->json($result, 200);
    }

    public function searchOneWay(Request $request)
        {
            $request->validate([
                'from_city_id' => 'required|integer',
                'to_city_id' => 'required|integer',
            ]);
        
            $tripType = TripType::where('name', 'oneway')->first();
        
            $packages = Package::with(['vendor', 'cab'])
                ->where('trip_type_id', $tripType->id)
                ->where('from_city_id', $request->from_city_id)
                ->where('to_city_id', $request->to_city_id)
                ->get();
        
            if ($packages->isEmpty()) {
                return response()->json(['message' => 'No cabs available'], 404);
            }
        
            // distance from routes table
            $distance = Route::where('from_city_id', $request->from_city_id)
                ->where('to_city_id', $request->to_city_id)
                ->value('distance_km') ?? 0;
        
            $result = $packages->map(function ($pkg) use ($distance) {

                // 1. Base Fare = price_per_km * distance
                $baseFare = ($pkg->price_per_km * $distance);
            
                // 2. Discount (percentage)
                $discount = ($pkg->offer_price > 0)
                    ? ($baseFare * $pkg->offer_price / 100)
                    : 0;
            
                // 3. Fare after discount (for GST calculation)
                $fareAfterDiscount = $baseFare - $discount;
            
                // 4. Extra charges
                $da   = $pkg->da ?? 0;
                $toll = $pkg->toll_tax ?? 0;
            
                // 5. GST Amount (calculated after discount)
                $gstAmount = (($fareAfterDiscount + $da + $toll) * $pkg->gst) / 100;
            
                // 6. Final Fare
                $finalFare = round($fareAfterDiscount + $da + $toll + $gstAmount);
            
                // 7. ORIGINAL AMOUNT before discount (required for UI)
                $originalAmount = round($baseFare + $da + $toll + (($baseFare + $da + $toll) * $pkg->gst / 100));
            
                return [
                    'vendor_id'          => $pkg->vendor_id,
                    'cab_id'             => $pkg->cab_id,
                    'package_id'         => $pkg->id,
                    'trip_type'          => $pkg->tripType->name ?? null,
                    'vendor'             => $pkg->vendor->name ?? null,
                    'cab_name'           => $pkg->cab->cab_name,
                    'cab_type'           => $pkg->cab->cab_type ?? null,
                    'distance_km'        => $distance,
                    'capacity'           => $pkg->cab->capacity ?? null,
                    
                    // Fare Calculation
                    'base_fare'          => round($baseFare),
                    'price_per_km'       => $pkg->price_per_km,
                    'extra_price_per_km' => $pkg->extra_price_per_km,
            
                    // Discounts
                    'discount'           => round($discount),
                    'discount_percent'   => $pkg->offer_price,
            
                    // Extra charges
                    'da'                 => $da,
                    'toll_tax'           => $toll,
            
                    // GST
                    'gst_amount'         => round($gstAmount),
                    'gst'                => $pkg->gst,
            
                    // Final & Original price
                    'final_fare'         => $finalFare,
                    'original_fare'      => $originalAmount,
            
                    // Image
                    'image'              => $pkg->cab->image ? asset("storage/{$pkg->cab->image}") : null,
                ];
            });
            
        
            return response()->json($result, 200);
        }
    public function searchRoundTrip(Request $request)
        {
            $request->validate([
                'from_city_id' => 'required|integer',
                'to_city_id' => 'required|integer',
            ]);

            $tripType = TripType::where('name', 'roundtrip')->first();

            $packages = Package::with(['vendor', 'cab'])
                ->where('trip_type_id', $tripType->id)
                ->where('from_city_id', $request->from_city_id)
                ->where('to_city_id', $request->to_city_id)
                ->get();

            if ($packages->isEmpty()) {
                return response()->json(['message' => 'No cabs found'], 404);
            }

            $onewayDistance = Route::where('from_city_id', $request->from_city_id)
                ->where('to_city_id', $request->to_city_id)
                ->value('distance_km') ?? 0;

            $distance = $onewayDistance * 2;

            // $result = $packages->map(function ($pkg) use ($distance) {

            //     $baseFare = $pkg->base_price + ($pkg->price_per_km * $distance);
            //     $discount = ($pkg->offer_price > 0) ? ($baseFare * $pkg->offer_price / 100) : 0;

            //     $fareAfterDiscount = $baseFare - $discount;

            //     $da = $pkg->da ?? 0;
            //     $toll = $pkg->toll_tax ?? 0;

            //     $gstAmount = (($fareAfterDiscount + $da + $toll) * $pkg->gst) / 100;
            //     $finalFare = round($fareAfterDiscount + $da + $toll + $gstAmount);

            //     return [
            //         'distance_km'  => $distance,
            //         'final_fare'   => $finalFare,
            //         'details'      => [
            //             'base_fare' => $baseFare,
            //             'discount' => $discount,
            //             'da' => $da,
            //             'toll' => $toll,
            //             'gst_amount' => $gstAmount
            //         ],
            //         'cab_name'     => $pkg->cab->cab_name,
            //         'image'        => $pkg->cab->image ? asset("storage/{$pkg->cab->image}") : null,
            //     ];
            // });
            $result = $packages->map(function ($pkg) use ($distance) {

                // 1. Base Fare = price_per_km * distance
                $baseFare = ($pkg->price_per_km * $distance);
            
                // 2. Discount (percentage)
                $discount = ($pkg->offer_price > 0)
                    ? ($baseFare * $pkg->offer_price / 100)
                    : 0;
            
                // 3. Fare after discount (for GST calculation)
                $fareAfterDiscount = $baseFare - $discount;
            
                // 4. Extra charges
                $da   = $pkg->da ?? 0;
                $toll = $pkg->toll_tax ?? 0;
            
                // 5. GST Amount (calculated after discount)
                $gstAmount = (($fareAfterDiscount + $da + $toll) * $pkg->gst) / 100;
            
                // 6. Final Fare
                $finalFare = round($fareAfterDiscount + $da + $toll + $gstAmount);
            
                // 7. ORIGINAL AMOUNT before discount (required for UI)
                $originalAmount = round($baseFare + $da + $toll + (($baseFare + $da + $toll) * $pkg->gst / 100));
            
                return [
                    'vendor_id'          =>$pkg->vendor_id,
                    'cab_id'             =>$pkg->cab_id,
                    'package_id'         => $pkg->id,
                    'trip_type'          => $pkg->tripType->name ?? null,
                    'vendor'             => $pkg->vendor->name ?? null,
                    'cab_name'           => $pkg->cab->cab_name,
                    'cab_type'           => $pkg->cab->cab_type ?? null,
                    'distance_km'        => $distance,
                    'capacity'           => $pkg->cab->capacity ?? null,
                    
                    // Fare Calculation
                    'base_fare'          => round($baseFare),
                    'price_per_km'       => $pkg->price_per_km,
                    'extra_price_per_km' => $pkg->extra_price_per_km,
            
                    // Discounts
                    'discount'           => round($discount),
                    'discount_percent'   => $pkg->offer_price,
            
                    // Extra charges
                    'da'                 => $da,
                    'toll_tax'           => $toll,
            
                    // GST
                    'gst_amount'         => round($gstAmount),
                    'gst'                => $pkg->gst,
            
                    // Final & Original price
                    'final_fare'         => $finalFare,
                    'original_fare'      => $originalAmount,
            
                    // Image
                    'image'              => $pkg->cab->image ? asset("storage/{$pkg->cab->image}") : null,
                ];
            });

            return response()->json($result, 200);
        }

    public function searchLocal(Request $request)
    {
        $request->validate([
            'from_city_id' => 'required|integer',
            'hours' => 'required|integer',
            'kms' => 'required|integer',
        ]);
    
        $tripType = TripType::where('name', 'local')->first();
    
        $packages = Package::with(['vendor', 'cab'])
            ->where('trip_type_id', $tripType->id)
            ->where('from_city_id', $request->from_city_id)
            ->where('hours', $request->hours)
            ->where('kms', $request->kms)
            ->get();
    
        if ($packages->isEmpty()) {
            return response()->json(['message' => 'No Local Packages'], 404);
        }
    
        $userDistance = $request->kms ?? 0;
    
        $result = $packages->map(function ($pkg) use ($userDistance) {

            $includedKm = $pkg->kms;
            
            // Calculate extra kms beyond included kms
            // $extraKm = $userDistance > $includedKm ? $userDistance - $includedKm : 0;
            // $chargedKm = $userDistance > $includedKm ? $userDistance : $includedKm;
    
            // Base fare calculation - only pay for extra kms beyond included
            $baseFare = ($pkg->extra_price_per_km * $includedKm);
    
            // Discount calculation
            $discount = ($pkg->offer_price > 0) ? ($baseFare * $pkg->offer_price / 100) : 0;
    
            $fareAfterDiscount = $baseFare - $discount;
    
            $da = $pkg->da ?? 0;
            $toll = $pkg->toll_tax ?? 0;

            
    
            $gstAmount = (($fareAfterDiscount + $da + $toll) * $pkg->gst) / 100;
    
            $finalFare = round($fareAfterDiscount + $da + $toll + $gstAmount);
            
            // Original amount without discount
            $originalAmount = round($baseFare + $da + $toll + (($baseFare + $da + $toll) * $pkg->gst / 100));
    
            return [
                'vendor_id'          =>$pkg->vendor_id,
                'cab_id'             =>$pkg->cab_id,
                'package_id'         => $pkg->id,
                'trip_type'          => $pkg->tripType->name ?? null,
                'vendor'             => $pkg->vendor->name ?? null,
                'cab_name'           => $pkg->cab->cab_name,
                'cab_type'           => $pkg->cab->cab_type ?? null,
                
                // Distance details
                'included_km'        => $includedKm,
                'hours'              => $pkg->hours,
                
                // Fare Calculation
                'base_fare'          => round($baseFare),
                'base_price'         => $pkg->base_price,
                'price_per_km'       => $pkg->price_per_km,
                'extra_price_per_km' => $pkg->extra_price_per_km,

                'capacity'           => $pkg->cab->capacity ?? null,
    
                // Discounts
                'discount'           => round($discount),
                'discount_percent'   => $pkg->offer_price,
    
                // Extra charges
                'da'                 => $da,
                'toll_tax'           => $toll,
    
                // GST
                'gst_amount'         => round($gstAmount),
                'gst'                => $pkg->gst,
    
                // Final & Original price
                'final_fare'         => $finalFare,
                'original_fare'      => $originalAmount,
    
                'image'              => $pkg->cab->image ? asset("storage/{$pkg->cab->image}") : null,
            ];
        });
    
        return response()->json($result, 200);
    }

    public function searchAirport(Request $request)
        {
            $request->validate([
                'airport_id' => 'required|integer',
                'airport_type' => 'required|in:pickup,drop',
                'city_id' => 'required|integer'
            ]);

            $tripType = TripType::where('name', 'airport')->first();

            $packages = Package::with(['vendor', 'cab'])
                ->where('trip_type_id', $tripType->id)
                ->where('airport_id', $request->airport_id)
                ->where('airport_type', $request->airport_type)
                ->where('from_city_id', $request->city_id)
                ->get();

            if ($packages->isEmpty()) {
                return response()->json(['message' => 'No Airport packages'], 404);
            }

            $result = $packages->map(function ($pkg) {

                $distance = $pkg->airport_min_km;

                $baseFare = ($pkg->price_per_km * $distance);

                $discount = ($pkg->offer_price > 0)? ($baseFare * $pkg->offer_price / 100): 0;

                $fareAfterDiscount = $baseFare - $discount;

                $da = $pkg->da ?? 0;
                $toll = $pkg->toll_tax ?? 0;

                $gstAmount = (($fareAfterDiscount + $da + $toll) * $pkg->gst) / 100;

                $finalFare = round($fareAfterDiscount + $da + $toll + $gstAmount);

                  // 7. ORIGINAL AMOUNT before discount (required for UI)
                  $originalAmount = round($baseFare + $da + $toll + (($baseFare + $da + $toll) * $pkg->gst / 100));

                  return [
                    'vendor_id'          =>$pkg->vendor_id,
                    'cab_id'             =>$pkg->cab_id,
                    'package_id'         => $pkg->id,
                    'trip_type'          => $pkg->tripType->name ?? null,
                    'vendor'             => $pkg->vendor->name ?? null,
                    'cab_name'           => $pkg->cab->cab_name,
                    'cab_type'           => $pkg->cab->cab_type ?? null,
                    'distance_km'        => $distance,
                    'capacity'           => $pkg->cab->capacity ?? null,
                    
                    // Fare Calculation
                    'base_fare'          => round($baseFare),
                    'price_per_km'       => $pkg->price_per_km,
                    'extra_price_per_km' => $pkg->extra_price_per_km,
            
                    // Discounts
                    'discount'           => round($discount),
                    'discount_percent'   => $pkg->offer_price,
            
                    // Extra charges
                    'da'                 => $da,
                    'toll_tax'           => $toll,
            
                    // GST
                    'gst_amount'         => round($gstAmount),
                    'gst'                => $pkg->gst,
            
                    // Final & Original price
                    'final_fare'         => $finalFare,
                    'original_fare'      => $originalAmount,
            
                    // Image
                    'image'              => $pkg->cab->image ? asset("storage/{$pkg->cab->image}") : null,
                ];
            });

            return response()->json($result, 200);
        }


}
