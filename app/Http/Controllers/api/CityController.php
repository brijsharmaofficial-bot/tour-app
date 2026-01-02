<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Airport;

class CityController extends Controller
{
    public function index() {
       // Return both id and name for each city
        return City::orderBy('name')->get(['id', 'name','state','country']);
   }
  
     public function getAirportCities()
        {
            $airports = Airport::orderBy('name')->get(['id', 'name']);
            $cities = City::orderBy('name')->get(['id', 'name','state']);

            return response()->json([
                'airports' => $airports,
                'cities' => $cities,
            ]);
        }
  
}
