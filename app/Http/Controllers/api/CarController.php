<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleType;
use App\Models\CarOption;

class CarController extends Controller
{
  
    public function VehicleTypes() {
       return VehicleType::all();
    }

  //  public function cityWiseCarOptions(Request $request)
  //     {
  //         $from_id = $request->query('from');
  //         $to_id = $request->query('to');

  //         $carOptions = CarOption::where('from_city_id', $from_id)
  //             ->where('to_city_id', $to_id)
  //             ->with(['VehicleType', 'fromCity', 'toCity']) // Optional: eager load relations
  //             ->get();

  //         return response()->json($carOptions);
  //     }
    public function cityWiseCarOptions(Request $request)
        {
            $from_id = $request->query('from');
            $to_id = $request->query('to');
            $trip_type = $request->query('trip_type');

            $carOptions = CarOption::where('from_city_id', $from_id)
                ->where('to_city_id', $to_id)
                ->with(['VehicleType', 'fromCity', 'toCity'])
                ->get()
                ->map(function ($car) use ($trip_type) {
                    $rate_per_km = $car->VehicleType->rate_per_km ?? 0;
                    $distance = $car->distance ?? 0;
                    $da = $car->da ?? 0;
                    $baseFare = $rate_per_km * $distance;

                    if ($trip_type === 'roundtrip') {
                        $discounted = $baseFare * 2 * 0.9 + $da;
                        $gst = $discounted * 0.05;
                        $total_fare = $discounted + $gst;
                        $savings = 106;
                        $discount_price = $total_fare + $savings;
                    } else {
                        if ($trip_type === 'oneway') {
                            $total = $baseFare + 200 + $da;
                        } elseif ($trip_type === 'airport') {
                            $total = $baseFare + 300 + $da;
                        } else {
                            $total = $baseFare + $da;
                        }
                        $gst = $total * 0.05;
                        $total_fare = $total + $gst;
                        $savings = 106;
                        $discount_price = $total_fare + $savings;
                    }

                    $result = [
                        'id' => $car->id,
                        'car_type_id' => $car->car_type_id,
                        'name' => $car->name,
                        'image' => $car->image,
                        'equivalent' => $car->equivalent,
                        'total_fare' => round($total_fare),
                        'discount_price' => $discount_price,
                        'savings' => $savings,
                        'distance' => $distance,
                        'rate_per_km' => $rate_per_km,
                        'rate_per_max_km'=> $car->VehicleType->rate_per_max_km ?? 0,
                        'isLimitedOffer' => $car->isLimitedOffer,
                        'da' => $da,
                        'gst' => round($gst, 2),
                        // Add any other fields you need
                    ];
                    return $result;
                });

            return response()->json($carOptions);
        }

    public function localCarOptions(Request $request)
        {
            $city = $request->query('city_id');
            $hours = $request->query('hours');
            $distance = $request->query('distance');

            $carOptions = CarOption::where('from_city_id', $city)
                ->where('hour', $hours)
                ->where('local_distance', $distance)
                ->with(['VehicleType'])
                ->get()
                ->map(function ($car) {
                    $rate_per_km = $car->rate_per_km ?? 0;
                    $rate_per_max_km = $car->rate_per_max_km ?? 0; 
                    $distance = $car->local_distance ?? 0;
                    $da = $car->da ?? 0;
                    $baseFare = $rate_per_km * $distance;

                    $total = $baseFare + $da;
                    $gst = $total * 0.05;
                    $total_fare = $total + $gst;

                    $original_price = $total_fare;
                    $savings = 106;
                    $discount_price = $total_fare + $savings;
                    return [
                        'id' => $car->id,
                        'car_type_id' => $car->car_type_id,
                        'name' => $car->name,
                        'image' => $car->image,
                        'equivalent' => $car->equivalent,
                        'total_fare' => round($total_fare),
                        'discount_price' => round($discount_price),
                        'savings' => $savings,
                        'distance' => $distance,
                        'rate_per_km' => $rate_per_km,
                        'rate_per_max_km' => $rate_per_max_km, // Include rate_per_max_km
                        'isLimitedOffer' => $car->isLimitedOffer,
                        'da' => $da,
                        'gst' => round($gst, 2),
                        'hour' => $car->hour,
                        'local_distance' => $car->local_distance,
                        'extra_hr_price'=> $car->extra_hr_price,
                    ];
                });

            return response()->json($carOptions);
        }

    public function airportCarOptions(Request $request)
    {
        $from_id = $request->query('from');
        $to_id = $request->query('to');

        $carOptions = CarOption::where('from_city_id', $from_id)
            ->where('to_city_id', $to_id)
            ->with(['VehicleType', 'fromCity', 'toCity'])
            ->get()
            ->map(function ($car) {
                $rate_per_km = $car->VehicleType->rate_per_km ?? 0;
                $rate_per_max_km = $car->VehicleType->rate_per_max_km ?? 0;
                $distance = $car->distance ?? 0;
                $da = $car->da ?? 0;
                $baseFare = $rate_per_km * $distance;

                // Airport trip: add 300 to base fare
                $total = $baseFare + 300 + $da;
                $gst = $total * 0.05;
                $total_fare = $total + $gst;

                return [
                    'id' => $car->id,
                    'car_type_id' => $car->car_type_id,
                    'name' => $car->name,
                    'image' => $car->image,
                    'equivalent' => $car->equivalent,
                    'total_fare' => round($total_fare),
                    'discount_price' => round($total_fare),
                    'savings' => 0,
                    'distance' => $distance,
                    'rate_per_km' => $rate_per_km,
                    'rate_per_max_km' => $rate_per_max_km,
                    'isLimitedOffer' => $car->isLimitedOffer,
                    'da' => $da,
                    'gst' => round($gst, 2),
                ];
            });

        return response()->json($carOptions);
    }
}
