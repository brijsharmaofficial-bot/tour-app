<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'vehicle_type', 'vehicle_number', 'license_number', 'license_expiry',
        'insurance_number', 'insurance_expiry', 'vehicle_documents', 'vehicle_color',
        'vehicle_model', 'vehicle_year'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
