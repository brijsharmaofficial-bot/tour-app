<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'vendor_id',
        'cab_id',
        'trip_type_id',
        'from_city_id',
        'to_city_id',
        'offer_price',
        'price_per_km',
        'extra_price_per_km',
        'da',
        'toll_tax',
        'gst',
        'hours',
        'kms',
        'airport_type',
        'airport_id',
        'airport_min_km',
        'status'
    ];

    public function vendor()      { return $this->belongsTo(Vendor::class); }
    public function cab()         { return $this->belongsTo(Cab::class); }
    public function tripType()    { return $this->belongsTo(TripType::class); }
    public function fromCity()    { return $this->belongsTo(City::class, 'from_city_id'); }
    public function toCity()      { return $this->belongsTo(City::class, 'to_city_id'); }
    public function airport()     { return $this->belongsTo(Airport::class); }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    // public function pricingDetails()
    //     {
    //         return $this->hasMany(PackagePricingDetail::class);
    //     }
}

?>