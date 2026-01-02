<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePricingDetail extends Model
{
    protected $fillable = ['package_id', 'hours', 'kms', 'price'];

    // public function package()
    // {
    //     return $this->belongsTo(Package::class);
    // }
}
