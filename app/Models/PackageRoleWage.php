<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class PackageRoleWage extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
