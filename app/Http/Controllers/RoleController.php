<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = auth()->user()->roles()->orderBy('id', 'desc')->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        auth()->user()->roles()->create($validated);
        return redirect()->back()->with('success', 'Đã thêm vai trò mới!');
    }

    public function update(Request $request, Role $role)
    {
        abort_if($role->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role->update($validated);
        return redirect()->back()->with('success', 'Đã cập nhật vai trò!');
    }

    public function destroy(Role $role)
    {
        abort_if($role->user_id !== auth()->id(), 403);

        $role->delete();
        return redirect()->back()->with('success', 'Đã xóa vai trò khỏi hệ thống!');
    }
}
