<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = ['name', 'city_id', 'status'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
