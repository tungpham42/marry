<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model {
    protected $guarded = [];
    protected $casts = ['paid_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
}
