<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageRoleWage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index() {
        $packages = auth()->user()->packages()->with('roleWages')->orderBy('id', 'desc')->get();
        return view('packages.index', compact('packages'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        auth()->user()->packages()->create($validated);

        return redirect()->back()->with('success', 'Thêm gói chụp thành công!');
    }

    public function update(Request $request, Package $package) {
        abort_if($package->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $package->update($validated);

        return redirect()->back()->with('success', 'Cập nhật gói thành công!');
    }

    public function destroy(Package $package) {
        abort_if($package->user_id !== auth()->id(), 403);

        $package->delete();
        return redirect()->back()->with('success', 'Đã xóa gói chụp!');
    }

    // --- Cấu hình định mức ngày công ---

    public function storeWage(Request $request, Package $package) {
        abort_if($package->user_id !== auth()->id(), 403);

        $request->validate([
            'role' => 'required|string',
            'default_work_days' => 'required|numeric|min:0'
        ]);

        // Đảm bảo bản ghi phụ thuộc cũng lưu đúng user_id để quản lý đồng bộ
        $package->roleWages()->updateOrCreate(
            ['role' => $request->role],
            [
                'default_work_days' => $request->default_work_days,
                'user_id' => auth()->id()
            ]
        );

        return redirect()->back()->with('success', 'Cập nhật định mức ngày công thành công!');
    }

    public function destroyWage(PackageRoleWage $wage) {
        abort_if($wage->user_id !== auth()->id(), 403);

        $wage->delete();
        return redirect()->back()->with('success', 'Đã xóa định mức!');
    }
}
