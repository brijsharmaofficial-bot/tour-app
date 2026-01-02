<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarOption extends Model
{
     protected $fillable = [
        'name', 'image', 'equivalent',
        'distance', 'is_limited_offer', 'car_type_id', 'from_city_id', 'to_city_id','da','gst','trip_type','hour','local_distance','rate_per_km', 'rate_per_max_km'
    ];

    public function VehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }
}
