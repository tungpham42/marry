<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model {
    protected $guarded = [];
    protected $casts = ['date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
    public function booking() { return $this->belongsTo(Booking::class); }
}
