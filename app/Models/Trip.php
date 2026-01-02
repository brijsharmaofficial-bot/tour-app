<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function routes() {
        return $this->hasMany(TripRoute::class);
    }

    public function logs() {
        return $this->hasMany(TripLog::class);
    }

    public function review() {
        return $this->hasOne(Review::class);
    }

    public function invoice() {
        return $this->hasOne(Invoice::class);
    }
}
