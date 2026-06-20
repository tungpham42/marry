<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthController; // Controller xử lý logic Auth

// 1. Trang chủ công khai (hoặc có thể chuyển hướng tùy bạn)
Route::get('/', function () {
    return view('welcome');
});

// 2. Các Tuyến Đường AUTH (Dành cho Khách / Chưa đăng nhập)
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Đăng xuất (Bắt buộc phải đăng nhập mới dùng được)
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// 3. Hệ Thống Quản Lý Nội Bộ (Bắt buộc ĐÃ ĐĂNG NHẬP)
Route::middleware(['auth', 'tenant.subdomain'])->group(function () {

    // Quản lý Nhân sự
    Route::resource('employees', EmployeeController::class)->except(['create', 'show', 'edit']);

    // Quản lý Gói chụp
    Route::post('packages/{package}/wages', [PackageController::class, 'storeWage'])->name('packages.wages.store');
    Route::delete('wages/{wage}', [PackageController::class, 'destroyWage'])->name('wages.destroy');
    Route::resource('packages', PackageController::class)->except(['create', 'show', 'edit']);

    // Quản lý Lịch chụp & Điều phối
    Route::post('bookings/{booking}/crew', [BookingController::class, 'assignCrew'])->name('bookings.crew.assign');
    Route::put('bookings/{booking}/crew/{employee}', [BookingController::class, 'updateTimesheet'])->name('bookings.crew.update');
    Route::delete('bookings/{booking}/crew/{employee}', [BookingController::class, 'removeCrew'])->name('bookings.crew.remove');
    Route::resource('bookings', BookingController::class)->except(['create', 'show', 'edit']);

    // Quản lý Phạt / Khấu trừ
    Route::resource('deductions', DeductionController::class)->except(['create', 'show', 'edit']);

    // Quản lý Bảng lương
    Route::get('payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::post('payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');
    Route::patch('/payrolls/{payroll}/status', [PayrollController::class, 'updateStatus'])->name('payrolls.status');

    // Quản lý Vai trò Nhân sự
    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);
});
