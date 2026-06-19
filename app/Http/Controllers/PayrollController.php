<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->has('month') ? (int)$request->input('month') : (int)date('m');
        $year = $request->has('year') ? (int)$request->input('year') : (int)date('Y');

        // Chỉ tải bảng lương thuộc về User hiện tại
        $payrolls = auth()->user()->payrolls()
                           ->with('employee')
                           ->where('month', $month)
                           ->where('year', $year)
                           ->get();

        return view('payrolls.index', compact('payrolls', 'month', 'year'));
    }

    public function generate(Request $request)
    {
        $request->merge([
            'month' => $request->has('month') ? (int)$request->month : null,
            'year' => $request->has('year') ? (int)$request->year : null,
        ]);

        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
        ]);

        $month = $request->month;
        $year = $request->year;

        // Chỉ tính toán trên danh sách nhân sự thuộc về Studio của User này
        $employees = auth()->user()->employees()->with([
            'bookings' => function($query) use ($month, $year) {
                $query->whereMonth('shoot_date', $month)
                      ->whereYear('shoot_date', $year)
                      ->wherePivot('status', 'completed');
            },
            'deductions' => function($query) use ($month, $year) {
                $query->whereMonth('date', $month)
                      ->whereYear('date', $year);
            }
        ])->get();

        foreach ($employees as $emp) {
            $totalWorkDays = $emp->bookings->sum('pivot.credited_work_days');
            $totalAllowance = $emp->bookings->sum('pivot.allowance_amount');
            $totalDeduction = $emp->deductions->sum('amount');

            $salaryByDays = $totalWorkDays * $emp->base_salary_per_day;
            $finalSalary = $salaryByDays + $totalAllowance - $totalDeduction;

            if ($totalWorkDays == 0 && $totalDeduction == 0 && $totalAllowance == 0) {
                continue;
            }

            // Đảm bảo updateOrCreate kiểm tra thêm cả user_id để tránh ghi đè chéo data
            Payroll::updateOrCreate(
                [
                    'employee_id' => $emp->id,
                    'month' => $month,
                    'year' => $year,
                    'user_id' => auth()->id()
                ],
                [
                    'total_work_days' => $totalWorkDays,
                    'salary_by_days' => $salaryByDays,
                    'total_allowance' => $totalAllowance,
                    'total_deduction' => $totalDeduction,
                    'final_salary' => $finalSalary,
                    'status' => 'draft'
                ]
            );
        }

        return redirect()->route('payrolls.index', ['month' => $month, 'year' => $year])
                         ->with('success', "Đã tổng hợp thành công bảng lương tháng $month/$year!");
    }

    public function updateStatus(Request $request, Payroll $payroll)
    {
        // 1. Kiểm tra bảo mật: Chỉ cho phép chủ studio (User) sở hữu bản ghi này được sửa
        abort_if($payroll->user_id !== auth()->id(), 403);

        // 2. Validate dữ liệu đầu vào
        $request->validate([
            'status' => 'required|in:draft,approved,paid'
        ]);

        // 3. Cập nhật trạng thái
        $payroll->update([
            'status' => $request->status
        ]);

        // Trả về thông báo thành công
        $statusText = match($request->status) {
            'paid' => 'Đã chi trả',
            'approved' => 'Đã duyệt',
            default => 'Nháp (Tạm tính)',
        };

        return redirect()->back()->with('success', "Đã cập nhật trạng thái lương thành: {$statusText}!");
    }
}
