<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Booking extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    protected $casts = [
        'shoot_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Danh sách ê-kíp đi show này
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'booking_employee')
                    ->withPivot('id', 'assigned_role', 'checked_in_at', 'checked_out_at', 'status', 'ot_hours', 'allowance_amount', 'allowance_note', 'credited_work_days')
                    ->withTimestamps();
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }
}
