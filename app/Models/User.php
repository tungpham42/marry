<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Các quan hệ sở hữu nội dung của User
    public function bookings(): HasMany { return $this->hasMany(Booking::class); }
    public function deductions(): HasMany { return $this->hasMany(Deduction::class); }
    public function employees(): HasMany { return $this->hasMany(Employee::class); }
    public function packages(): HasMany { return $this->hasMany(Package::class); }
    public function packageRoleWages(): HasMany { return $this->hasMany(PackageRoleWage::class); }
    public function payrolls(): HasMany { return $this->hasMany(Payroll::class); }
    public function roles(): HasMany { return $this->hasMany(Role::class); }
}
