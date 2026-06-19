<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Models\Employee;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeductionController extends Controller
{
    public function index()
    {
        // Lọc toàn bộ dữ liệu theo User đang đăng nhập
        $deductions = auth()->user()->deductions()->with(['employee', 'booking'])->orderBy('date', 'desc')->get();
        $employees = auth()->user()->employees()->where('status', 'active')->get();
        $bookings = auth()->user()->bookings()->orderBy('shoot_date', 'desc')->limit(50)->get();

        return view('deductions.index', compact('deductions', 'employees', 'bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('user_id', auth()->id())
            ],
            'booking_id' => [
                'nullable',
                Rule::exists('bookings', 'id')->where('user_id', auth()->id())
            ],
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Tạo thông qua quan hệ để tự động gán user_id
        auth()->user()->deductions()->create($validated);

        return redirect()->back()->with('success', 'Đã ghi nhận khoản khấu trừ/phạt!');
    }

    public function update(Request $request, Deduction $deduction)
    {
        abort_if($deduction->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('user_id', auth()->id())
            ],
            'booking_id' => [
                'nullable',
                Rule::exists('bookings', 'id')->where('user_id', auth()->id())
            ],
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $deduction->update($validated);

        return redirect()->back()->with('success', 'Đã cập nhật thông tin phạt!');
    }

    public function destroy(Deduction $deduction)
    {
        abort_if($deduction->user_id !== auth()->id(), 403);

        $deduction->delete();
        return redirect()->back()->with('success', 'Đã xóa bản ghi khấu trừ!');
    }
}
