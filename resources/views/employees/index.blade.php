@extends('layouts.app')

@section('title', 'Hồ Sơ Nhân Sự')

@section('content')
<div x-data="{
        showAddModal: false,
        showEditModal: false,
        emp: {}
    }"
    class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100 animate-fade-in-up relative overflow-hidden">

    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8 border-b border-stone-100 pb-6 relative z-10">
        <div>
            <h2 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                <span class="bg-amber-100 text-amber-600 p-2.5 rounded-2xl shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
                Hồ Sơ Nhân Sự
            </h2>
            <p class="text-sm font-medium text-stone-500 mt-2 ml-1">Quản lý danh sách thành viên, thông tin liên lạc và mức lương cơ bản.</p>
        </div>

        <button @click="showAddModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Thêm Nhân Sự Mới
        </button>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-stone-100 shadow-sm relative z-10">
        <table class="min-w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-stone-50/80 border-b border-stone-100">
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">ID</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Họ Tên & Vị trí</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Liên hệ</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-right">Lương / Ngày</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Trạng thái</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($employees as $employee)
                <tr class="hover:bg-amber-50/30 transition-colors group">
                    <td class="p-4 font-semibold text-stone-400 text-sm">#{{ $employee->id }}</td>
                    <td class="p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center text-orange-800 font-bold text-sm shadow-inner shrink-0">
                            {{ mb_substr($employee->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-extrabold text-stone-800 text-base">{{ $employee->name }}</div>
                            <div class="text-sm font-semibold text-amber-600 mt-0.5">{{ $employee->primary_role }}</div>
                        </div>
                    </td>
                    <td class="p-4 text-sm font-medium text-stone-600">
                        <div class="space-y-1">
                            <div x-show="'{{ $employee->phone }}' !== ''" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $employee->phone }}
                            </div>
                            <div x-show="'{{ $employee->email }}' !== ''" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $employee->email }}
                            </div>
                            <div x-show="'{{ $employee->phone }}' === '' && '{{ $employee->email }}' === ''" class="text-stone-400 italic">Chưa cập nhật</div>
                        </div>
                    </td>
                    <td class="p-4 text-right">
                        <span class="inline-block bg-stone-100 text-stone-700 px-3 py-1.5 rounded-xl font-extrabold border border-stone-200">
                            {{ number_format($employee->base_salary_per_day) }}<span class="text-[11px] ml-0.5 opacity-70">đ</span>
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1.5 text-xs font-extrabold rounded-xl border shadow-sm tracking-wide inline-block
                            {{ $employee->status == 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
                            {{ $employee->status == 'active' ? 'ĐANG LÀM VIỆC' : 'ĐÃ NGHỈ' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">
                            <button @click="emp = {{ json_encode($employee) }}; showEditModal = true"
                                    class="p-2 text-stone-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-colors" title="Chỉnh sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="p-2 text-stone-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-stone-500">
                        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-stone-50 text-stone-300 mb-4 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-stone-700 mb-1">Chưa có dữ liệu</h3>
                        <p class="text-sm">Hệ thống hiện tại chưa ghi nhận hồ sơ nhân viên nào.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <template x-teleport="body">
        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div x-show="showAddModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showAddModal = false"></div>

            <div x-show="showAddModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 border border-stone-100">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-amber-100 text-amber-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </span>
                        Thêm Nhân Sự
                    </h3>
                    <button type="button" @click="showAddModal = false" class="text-stone-400 hover:text-amber-600 hover:bg-amber-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('employees.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Nhập tên nhân sự..." class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Số điện thoại</label>
                            <input type="tel" name="phone" placeholder="09xx..." class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Email</label>
                            <input type="email" name="email" placeholder="email@example.com" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Vai trò chính <span class="text-rose-500">*</span></label>
                            <select name="primary_role" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                                <option value="">-- Chọn vai trò --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-amber-600 mb-1.5">Lương 1 công (VNĐ) <span class="text-rose-500">*</span></label>
                            <input type="number" name="base_salary_per_day" required value="0" min="0" step="1000" class="w-full border-amber-200 rounded-xl p-3 bg-amber-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-extrabold text-amber-800 shadow-inner">
                        </div>
                    </div>

                    <input type="hidden" name="status" value="active">

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Lưu Thông Tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div x-show="showEditModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showEditModal = false"></div>

            <div x-show="showEditModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 border border-stone-100">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-amber-100 text-amber-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </span>
                        Cập nhật Thông tin
                    </h3>
                    <button type="button" @click="showEditModal = false" class="text-stone-400 hover:text-amber-600 hover:bg-amber-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/employees/' + emp.id" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="emp.name" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Số điện thoại</label>
                            <input type="tel" name="phone" x-model="emp.phone" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Email</label>
                            <input type="email" name="email" x-model="emp.email" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Vai trò chính <span class="text-rose-500">*</span></label>
                            <select name="primary_role" x-model="emp.primary_role" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                                <option value="">-- Chọn vai trò --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-amber-600 mb-1.5">Lương 1 công (VNĐ) <span class="text-rose-500">*</span></label>
                            <input type="number" name="base_salary_per_day" x-model="emp.base_salary_per_day" required min="0" step="1000" class="w-full border-amber-200 rounded-xl p-3 bg-amber-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-extrabold text-amber-800 shadow-inner">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tình trạng công việc <span class="text-rose-500">*</span></label>
                        <select name="status" x-model="emp.status" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition font-medium text-stone-800">
                            <option value="active">Đang làm việc</option>
                            <option value="inactive">Đã nghỉ việc</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Xóa nhân sự này?',
            text: "Toàn bộ thông tin hồ sơ sẽ bị xóa. Cân nhắc kỹ trước khi thực hiện!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Có, xóa ngay',
            cancelButtonText: 'Hủy bỏ',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>
@endsection
