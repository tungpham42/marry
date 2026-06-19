<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cấu hình mức ngày công cho từng vai trò trong gói này
    public function roleWages()
    {
        return $this->hasMany(PackageRoleWage::class);
    }

    // Các show chụp sử dụng gói này
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
