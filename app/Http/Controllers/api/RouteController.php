<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Route;

class RouteController extends Controller
{
     public function getDistance(Request $request)
    {
        $from = $request->query('from_city_id');
        $to = $request->query('to_city_id');
        $route = Route::where('from_city_id', $from)
                      ->where('to_city_id', $to)
                      ->first();

        if ($route) {
            return response()->json(['distance' => $route->distance]);
        } else {
            return response()->json(['distance' => null, 'message' => 'Route not found'], 404);
        }
    }
}
