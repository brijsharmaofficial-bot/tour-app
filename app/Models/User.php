<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'status','companyname','usergst',
    ];

    protected $hidden = ['password'];

    // 🔹 Role helpers
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    // 🔹 Relations (optional, if used elsewhere)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    
}
