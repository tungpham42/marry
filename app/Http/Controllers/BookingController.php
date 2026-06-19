<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index() {
        // Chỉ lấy lịch chụp, gói chụp và nhân viên thuộc về user đang đăng nhập
        $bookings = auth()->user()->bookings()->with(['package', 'employees'])->orderBy('shoot_date', 'desc')->get();
        $packages = auth()->user()->packages()->get();
        $employees = auth()->user()->employees()->where('status', 'active')->get();

        return view('bookings.index', compact('bookings', 'packages', 'employees'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            // Bảo mật: gói chụp được chọn phải thuộc sở hữu của user này
            'package_id' => [
                'required',
                Rule::exists('packages', 'id')->where('user_id', auth()->id())
            ],
            'shoot_date' => 'required|date',
            'status' => 'nullable|string'
        ]);

        auth()->user()->bookings()->create($validated);

        return redirect()->back()->with('success', 'Tạo lịch chụp thành công!');
    }

    public function update(Request $request, Booking $booking) {
        // Chống hack: Đảm bảo bản ghi này thuộc về user đang đăng nhập
        abort_if($booking->user_id !== auth()->id(), 403, 'Hành động không hợp lệ.');

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'package_id' => [
                'required',
                Rule::exists('packages', 'id')->where('user_id', auth()->id())
            ],
            'shoot_date' => 'required|date',
            'status' => 'nullable|string'
        ]);

        $booking->update($validated);

        return redirect()->back()->with('success', 'Cập nhật lịch chụp thành công!');
    }

    public function destroy(Booking $booking) {
        abort_if($booking->user_id !== auth()->id(), 403, 'Hành động không hợp lệ.');

        $booking->delete();
        return redirect()->back()->with('success', 'Đã xóa lịch chụp!');
    }

    // ==========================================
    // QUẢN LÝ Ê-KÍP VÀ CHẤM CÔNG (LOGIC ĐÃ FIX)
    // ==========================================

    public function assignCrew(Request $request, Booking $booking) {
        abort_if($booking->user_id !== auth()->id(), 403, 'Hành động không hợp lệ.');

        $request->validate([
            'employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('user_id', auth()->id())
            ],
            'assigned_role' => 'required|string|max:255'
        ]);

        $wage = $booking->package->roleWages()->where('role', $request->assigned_role)->first();

        if($booking->employees()->where('employee_id', $request->employee_id)->exists()) {
            return redirect()->back()->with('error', 'Nhân viên này đã có trong ê-kíp!');
        }

        $booking->employees()->attach($request->employee_id, [
            'assigned_role' => $request->assigned_role,
            'credited_work_days' => $wage ? $wage->default_work_days : 0,
            'status' => 'assigned'
        ]);

        return redirect()->back()->with('success', 'Đã phân công nhân sự vào show!');
    }

    public function updateTimesheet(Request $request, Booking $booking, Employee $employee) {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($employee->user_id !== auth()->id(), 403);

        $request->validate([
            'ot_hours' => 'nullable|numeric|min:0',
            'allowance_amount' => 'nullable|numeric|min:0',
            'allowance_note' => 'nullable|string|max:255',
            'credited_work_days' => 'required|numeric|min:0',
        ]);

        $booking->employees()->updateExistingPivot($employee->id, [
            'ot_hours' => $request->ot_hours ?? 0,
            'allowance_amount' => $request->allowance_amount ?? 0,
            'allowance_note' => $request->allowance_note,
            'credited_work_days' => $request->credited_work_days,
            'status' => 'completed',
            'checked_out_at' => now()
        ]);

        return redirect()->back()->with('success', "Đã chốt công cho {$employee->name}!");
    }

    public function removeCrew(Booking $booking, Employee $employee) {
        abort_if($booking->user_id !== auth()->id(), 403);
        abort_if($employee->user_id !== auth()->id(), 403);

        $booking->employees()->detach($employee->id);

        return redirect()->back()->with('success', "Đã gỡ {$employee->name} khỏi ê-kíp!");
    }
}
