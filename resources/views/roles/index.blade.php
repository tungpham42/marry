@extends('layouts.app')

@section('title', 'Quản Lý Vai Trò')

@section('content')
<div x-data="{
        showAddModal: false,
        showEditModal: false,
        roleData: {}
    }" class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100 animate-fade-in-up relative overflow-hidden">

    <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8 border-b border-stone-100 pb-6 relative z-10">
        <div>
            <h2 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                <span class="bg-teal-100 text-teal-600 p-2.5 rounded-2xl shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </span>
                Quản lý Vai trò (Roles)
            </h2>
            <p class="text-sm font-medium text-stone-500 mt-2 ml-1">Định nghĩa các vị trí công việc cho nhân sự trong studio.</p>
        </div>

        <button @click="showAddModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-teal-500/30 hover:shadow-teal-500/50 transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Thêm Vai Trò
        </button>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-stone-100 shadow-sm relative z-10">
        <table class="min-w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-stone-50/80 border-b border-stone-100">
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">ID</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider w-full">Tên Vai Trò</th>
                    <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($roles as $role)
                <tr class="hover:bg-teal-50/30 transition-colors group">
                    <td class="p-4 font-semibold text-stone-400 text-sm">#{{ $role->id }}</td>
                    <td class="p-4 font-extrabold text-stone-800 text-base">{{ $role->name }}</td>
                    <td class="p-4 flex justify-center items-center gap-2">
                        <button @click="roleData = {{ json_encode($role) }}; showEditModal = true"
                                class="p-2 text-stone-400 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors" title="Chỉnh sửa">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>

                        <form id="delete-role-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" class="m-0">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDeleteRole({{ $role->id }})" class="p-2 text-stone-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Xóa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-stone-500">
                        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-stone-50 text-stone-300 mb-4 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-stone-700 mb-1">Chưa có dữ liệu</h3>
                        <p class="text-sm">Hãy thêm các vai trò như "Thợ chính", "M.U.A"...</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <template x-teleport="body">
        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6">
            <div x-show="showAddModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showAddModal = false"></div>

            <div x-show="showAddModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative z-10 border border-stone-100">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-teal-100 text-teal-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </span>
                        Thêm Vai Trò
                    </h3>
                    <button type="button" @click="showAddModal = false" class="text-stone-400 hover:text-teal-600 hover:bg-teal-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('roles.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tên vai trò <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="VD: Thợ Phụ" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition font-medium text-stone-800">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            Lưu Lại
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6">
            <div x-show="showEditModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showEditModal = false"></div>

            <div x-show="showEditModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative z-10 border border-stone-100">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-teal-100 text-teal-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </span>
                        Cập Nhật Vai Trò
                    </h3>
                    <button type="button" @click="showEditModal = false" class="text-stone-400 hover:text-teal-600 hover:bg-teal-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/roles/' + roleData.id" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tên vai trò <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="roleData.name" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition font-medium text-stone-800">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            Lưu Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

<script>
    function confirmDeleteRole(id) {
        Swal.fire({
            title: 'Xóa vai trò này?',
            text: "Thao tác này không ảnh hưởng đến các nhân viên đang mang vai trò này (do lưu dạng text).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-role-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
