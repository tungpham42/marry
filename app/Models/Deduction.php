<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Deduction extends Model {
    use BelongsToTenant;
    protected $guarded = [];
    protected $casts = ['date' => 'date'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function booking() { return $this->belongsTo(Booking::class); }
}
