@extends('layouts.app')

@section('content')
<div x-data="{
        showAddModal: false,
        showEditModal: false,
        pkg: {},
        expanded: null
    }" class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100 animate-fade-in-up relative overflow-hidden">

    <div class="absolute top-0 right-0 w-64 h-64 bg-violet-500/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8 border-b border-stone-100 pb-6 relative z-10">
        <div>
            <h2 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                <span class="bg-violet-100 text-violet-600 p-2.5 rounded-2xl shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </span>
                Gói Dịch Vụ & Định Mức
            </h2>
            <p class="text-sm font-medium text-stone-500 mt-2 ml-1">Thiết lập các gói chụp và cấu hình ngày công mặc định cho từng vai trò.</p>
        </div>

        <button @click="showAddModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-violet-500 to-fuchsia-500 hover:from-violet-600 hover:to-fuchsia-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-violet-500/30 hover:shadow-violet-500/50 transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Thêm Gói Mới
        </button>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-stone-100 shadow-sm relative z-10">
        <table class="min-w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-stone-50/80 border-b border-stone-100">
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Tên gói dịch vụ</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-right">Giá bán</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($packages as $package)
                <tr class="hover:bg-violet-50/30 transition-colors group">
                    <td class="p-4 cursor-pointer" @click="expanded = expanded === {{ $package->id }} ? null : {{ $package->id }}" title="Bấm để mở rộng định mức">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-extrabold text-stone-800 text-base group-hover:text-violet-600 transition-colors">{{ $package->name }}</div>
                                <div class="text-xs font-semibold text-stone-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Bấm để cấu hình định mức ngày công
                                </div>
                            </div>
                            <div class="text-stone-300 group-hover:text-violet-500 transition-transform duration-300" :class="expanded === {{ $package->id }} ? 'rotate-180' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-right">
                        <span class="inline-block bg-stone-100 text-stone-800 px-3 py-1.5 rounded-xl font-extrabold border border-stone-200">
                            {{ number_format($package->price) }}<span class="text-[11px] ml-0.5 opacity-70">đ</span>
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">
                            <button @click="pkg = {{ json_encode($package) }}; showEditModal = true"
                                    class="p-2 text-stone-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-colors" title="Chỉnh sửa gói">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <form id="delete-package-form-{{ $package->id }}" action="{{ route('packages.destroy', $package->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDeletePackage({{ $package->id }})" class="p-2 text-stone-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Xóa gói">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <tr x-show="expanded === {{ $package->id }}" x-cloak class="bg-stone-50/50" x-transition>
                    <td colspan="3" class="p-0 border-b-2 border-violet-100 relative">
                        <div class="p-6 lg:p-8">
                            <h4 class="font-extrabold mb-5 text-violet-800 flex items-center gap-2 text-lg">
                                <span class="bg-violet-100 text-violet-600 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span>
                                Định mức công mặc định
                            </h4>

                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="flex-1">
                                    <div class="bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-sm">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-stone-50/80 border-b border-stone-100">
                                                    <th class="p-3.5 text-xs font-bold text-stone-500 uppercase tracking-wider">Vai trò / Vị trí</th>
                                                    <th class="p-3.5 text-xs font-bold text-stone-500 uppercase tracking-wider text-center">Công mặc định</th>
                                                    <th class="p-3.5 text-xs font-bold text-stone-500 uppercase tracking-wider text-right">Tùy chọn</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-stone-100">
                                                @forelse($package->roleWages as $wage)
                                                <tr class="hover:bg-stone-50 transition">
                                                    <td class="p-3.5 font-bold text-stone-700">{{ $wage->role }}</td>
                                                    <td class="p-3.5 text-center">
                                                        <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-lg font-extrabold border border-rose-100">
                                                            {{ $wage->default_work_days }} <span class="text-xs font-medium opacity-70">ngày</span>
                                                        </span>
                                                    </td>
                                                    <td class="p-3.5 text-right flex justify-end">

                                                        <form id="delete-wage-form-{{ $wage->id }}" action="{{ route('wages.destroy', $wage->id) }}" method="POST" class="m-0">
                                                            @csrf @method('DELETE')
                                                            <button type="button" onclick="confirmDeleteWage({{ $wage->id }})" class="text-stone-400 hover:text-rose-600 hover:bg-rose-50 px-2 py-1.5 rounded-lg transition-colors font-semibold text-sm flex items-center gap-1">
                                                                Xóa
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="p-8 text-center text-stone-500 bg-stone-50/50">
                                                        <div class="text-sm font-medium">Chưa cấu hình định mức ngày công cho gói này.</div>
                                                        <div class="text-xs text-stone-400 mt-1">Sử dụng form bên cạnh để thêm mới.</div>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="w-full lg:w-1/3 xl:w-1/4">
                                    <div class="bg-white border-2 border-violet-100 rounded-2xl shadow-lg shadow-violet-100/50 p-6">
                                        <h4 class="font-extrabold mb-4 text-stone-800 border-b border-stone-100 pb-2">Thêm định mức</h4>
                                        <form action="{{ route('packages.wages.store', $package->id) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-1.5">Tên Vai trò</label>
                                                <input list="role-suggestions-{{ $package->id }}" type="text" name="role" placeholder="VD: Thợ chính, M.U.A..." required class="w-full border-stone-200 rounded-xl p-2.5 text-sm font-medium bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition">
                                                <datalist id="role-suggestions-{{ $package->id }}">
                                                    <option value="Thợ chính">
                                                    <option value="Thợ phụ">
                                                    <option value="Quay phim">
                                                    <option value="M.U.A">
                                                    <option value="Trợ lý">
                                                </datalist>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-stone-500 uppercase tracking-wide mb-1.5">Số ngày công</label>
                                                <input type="number" step="0.1" min="0" name="default_work_days" placeholder="VD: 1.5" required class="w-full border-stone-200 rounded-xl p-2.5 text-sm font-bold bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition text-rose-600">
                                            </div>
                                            <button class="w-full bg-stone-900 text-white p-2.5 rounded-xl text-sm hover:bg-stone-800 font-bold shadow-md transition-all hover:-translate-y-0.5 mt-1 flex justify-center items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Lưu Định Mức
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-stone-500">
                        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-stone-50 text-stone-300 mb-4 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-stone-700 mb-1">Chưa có dữ liệu</h3>
                        <p class="text-sm">Vui lòng tạo các gói dịch vụ để bắt đầu sử dụng chức năng này.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <template x-teleport="body">
        <div x-show="showAddModal" x-cloak style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6">
            <div x-show="showAddModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showAddModal = false"></div>

            <div x-show="showAddModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 border border-stone-100 max-h-[90vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-violet-100 text-violet-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </span>
                        Thêm Gói Chụp
                    </h3>
                    <button type="button" @click="showAddModal = false" class="text-stone-400 hover:text-violet-600 hover:bg-violet-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('packages.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tên gói dịch vụ <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="VD: Pre-wedding ngoại cảnh Đà Lạt" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-medium text-stone-800">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-violet-600 mb-1.5">Giá bán (VNĐ) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" required min="0" step="1000" placeholder="0" class="w-full border-violet-200 rounded-xl p-3 bg-violet-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-extrabold text-violet-800 shadow-inner">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Mô tả (Tùy chọn)</label>
                        <textarea name="description" rows="3" placeholder="Ghi chú thêm về thông tin gói..." class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-medium text-stone-800"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Lưu Gói Chụp
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showEditModal" x-cloak style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6">
            <div x-show="showEditModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showEditModal = false"></div>

            <div x-show="showEditModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 border border-stone-100 max-h-[90vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-violet-100 text-violet-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </span>
                        Cập nhật Thông tin
                    </h3>
                    <button type="button" @click="showEditModal = false" class="text-stone-400 hover:text-violet-600 hover:bg-violet-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/packages/' + pkg.id" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tên gói dịch vụ <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="pkg.name" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-medium text-stone-800">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-violet-600 mb-1.5">Giá bán (VNĐ) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" x-model="pkg.price" required min="0" step="1000" class="w-full border-violet-200 rounded-xl p-3 bg-violet-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-extrabold text-violet-800 shadow-inner">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Mô tả (Tùy chọn)</label>
                        <textarea name="description" x-model="pkg.description" rows="3" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-violet-500/20 focus:border-violet-500 transition font-medium text-stone-800"></textarea>
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

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>

<script>
    function confirmDeletePackage(id) {
        Swal.fire({
            title: 'Xóa gói dịch vụ này?',
            text: "Toàn bộ định mức ngày công đi kèm sẽ bị xóa vĩnh viễn và không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-package-form-${id}`).submit();
            }
        })
    }

    function confirmDeleteWage(id) {
        Swal.fire({
            title: 'Gỡ bỏ định mức này?',
            text: "Định mức cho vai trò này sẽ bị xóa khỏi gói.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-wage-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
