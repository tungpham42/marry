<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\AuthorizesTenant;

class BookingController extends Controller
{
    use AuthorizesTenant;

    public function index() {
        // Lấy lịch chụp, gói chụp và nhân viên
        $bookings = Booking::with(['package', 'employees'])->orderBy('shoot_date', 'desc')->get();
        $packages = Package::get();
        $employees = Employee::where('status', 'active')->get();

        // Thêm dòng này để lấy danh sách Vai trò động
        $roles = Role::orderBy('name')->get();

        // Truyền thêm biến $roles sang view
        return view('bookings.index', compact('bookings', 'packages', 'employees', 'roles'));
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

        Booking::create($validated);

        return redirect()->back()->with('success', 'Tạo lịch chụp thành công!');
    }

    public function update(Request $request, Booking $booking) {
        $this->authorizeOwnership($booking);

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
        $this->authorizeOwnership($booking);

        $booking->delete();
        return redirect()->back()->with('success', 'Đã xóa lịch chụp!');
    }

    // ==========================================
    // QUẢN LÝ Ê-KÍP VÀ CHẤM CÔNG
    // ==========================================

    public function assignCrew(Request $request, Booking $booking) {
        $this->authorizeOwnership($booking);

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
        $this->authorizeOwnership($booking);
        $this->authorizeOwnership($employee);

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
        $this->authorizeOwnership($booking);
        $this->authorizeOwnership($employee);

        $booking->employees()->detach($employee->id);

        return redirect()->back()->with('success', "Đã gỡ {$employee->name} khỏi ê-kíp!");
    }
}
