<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'corporate_office',
        'gst_number',
        'bank_name',
        'bank_account',
        'ifsc_code',
        'notes'
    ];
}
