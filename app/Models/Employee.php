<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Lịch sử đi show của nhân viên
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_employee')
                    ->withPivot('assigned_role', 'checked_in_at', 'checked_out_at', 'status', 'ot_hours', 'allowance_amount', 'allowance_note', 'credited_work_days')
                    ->withTimestamps();
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
