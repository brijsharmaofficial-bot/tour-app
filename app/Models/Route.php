<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'from_city_id',
        'to_city_id',
        'distance_km',
        'approx_time',
        'toll_tax',
        'status',
    ];

    /**
     * Relationship: From City (Starting Point)
     */
    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    /**
     * Relationship: To City (Destination)
     */
    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    /**
     * Accessor: formatted distance with unit
     */
    public function getDistanceWithUnitAttribute()
    {
        return $this->distance_km ? "{$this->distance_km} km" : 'N/A';
    }

    /**
     * Scope: active routes only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
