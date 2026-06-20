<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\AuthorizesTenant;

class EmployeeController extends Controller
{
    use AuthorizesTenant;

    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->get();
        $roles = Role::orderBy('name')->get();

        return view('employees.index', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
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

        Employee::create($validated);
        return redirect()->back()->with('success', 'Đã thêm nhân viên thành công!');
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorizeOwnership($employee);

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
        $this->authorizeOwnership($employee);

        $employee->delete();
        return redirect()->back()->with('success', 'Đã xóa nhân viên khỏi hệ thống!');
    }
}
