<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = auth()->user()->employees()->orderBy('id', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Email chỉ duy nhất trong phạm vi của studio (User) này quản lý
            'email' => [
                'nullable',
                'email',
                Rule::unique('employees')->where('user_id', auth()->id())
            ],
            'phone' => 'nullable|string|max:20',
            'primary_role' => 'required|string',
            'base_salary_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        auth()->user()->employees()->create($validated);
        return redirect()->back()->with('success', 'Đã thêm nhân viên thành công!');
    }

    public function update(Request $request, Employee $employee)
    {
        abort_if($employee->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('employees')->ignore($employee->id)->where('user_id', auth()->id())
            ],
            'phone' => 'nullable|string|max:20',
            'primary_role' => 'required|string',
            'base_salary_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $employee->update($validated);
        return redirect()->back()->with('success', 'Đã cập nhật thông tin nhân viên!');
    }

    public function destroy(Employee $employee)
    {
        abort_if($employee->user_id !== auth()->id(), 403);

        $employee->delete();
        return redirect()->back()->with('success', 'Đã xóa nhân viên khỏi hệ thống!');
    }
}
