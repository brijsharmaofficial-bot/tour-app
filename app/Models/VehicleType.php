<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
  
    protected $fillable = ['name', 'icon', 'rate_per_km', 'rate_per_max_km'];

    public function carOptions()
    {
        return $this->hasMany(CarOption::class);
    }
}
