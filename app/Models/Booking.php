<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'vendor_id', 'cab_id', 'package_id',
        'from_city_id', 'to_city_id', 'pickup_date', 'pickup_time',
        'pickup_address', 'drop_address','distance_km',
        'total_estimated_fare','fare_without_gst',
        'status','payment_status','payment_id','trip_type','advanced_amount','company_name','gst_number','booking_reference',
    ];
    

    public function user() { return $this->belongsTo(User::class); }
    public function vendor() { return $this->belongsTo(Vendor::class); }
    public function cab() { return $this->belongsTo(Cab::class); }
    public function package() { return $this->belongsTo(Package::class); }
    public function fromCity() { return $this->belongsTo(City::class, 'from_city_id'); }
    public function toCity() { return $this->belongsTo(City::class, 'to_city_id'); }

    public function triptype()
    {
        return $this->belongsTo(TripType::class);
    }
}
