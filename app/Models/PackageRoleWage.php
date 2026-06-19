<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageRoleWage extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
