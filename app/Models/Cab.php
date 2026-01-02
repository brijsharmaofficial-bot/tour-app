<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cab extends Model
{
    protected $fillable = [
        'vendor_id', 'cab_name', 'cab_type', 'capacity', 'registration_no','image', 'status'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
    // Helper for cab image
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('no-image.png');
    }
}
