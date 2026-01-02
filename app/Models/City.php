<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 'state', 'country'
    ];

    public function fromPackages()
    {
        return $this->hasMany(Package::class, 'from_city_id');
    }

    public function toPackages()
    {
        return $this->hasMany(Package::class, 'to_city_id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function fromRoutes()
    {
        return $this->hasMany(Route::class, 'from_city_id');
    }

    public function toRoutes()
    {
        return $this->hasMany(Route::class, 'to_city_id');
    }
}
