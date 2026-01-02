<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'status'
    ];

    public function cabs()
    {
        return $this->hasMany(Cab::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
