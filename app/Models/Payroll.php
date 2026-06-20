<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Payroll extends Model {
    use BelongsToTenant;
    protected $guarded = [];
    protected $casts = ['paid_at' => 'datetime'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
