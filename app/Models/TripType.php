<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

        public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
