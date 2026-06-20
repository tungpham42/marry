<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\AuthorizesTenant;

class RoleController extends Controller
{
    use AuthorizesTenant;

    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Role::create($validated);
        return redirect()->back()->with('success', 'Đã thêm vai trò mới!');
    }

    public function update(Request $request, Role $role)
    {
        $this->authorizeOwnership($role);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role->update($validated);
        return redirect()->back()->with('success', 'Đã cập nhật vai trò!');
    }

    public function destroy(Role $role)
    {
        $this->authorizeOwnership($role);

        $role->delete();
        return redirect()->back()->with('success', 'Đã xóa vai trò khỏi hệ thống!');
    }
}
