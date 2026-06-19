@extends('layouts.app')

@section('content')
<div x-data="{
        showModal: false,
        isEdit: false,
        formData: {
            id: null,
            employee_id: '',
            date: '',
            amount: '',
            reason: '',
            booking_id: ''
        }
    }">

    <div class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100 animate-fade-in-up relative overflow-hidden">

        <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8 border-b border-stone-100 pb-6 relative z-10">
            <div>
                <h2 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                    <span class="bg-rose-100 text-rose-600 p-2.5 rounded-2xl shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </span>
                    Quản lý Phạt / Khấu trừ
                </h2>
                <p class="text-sm font-medium text-stone-500 mt-2 ml-1">Ghi nhận các vi phạm, sự cố và khấu trừ lương của nhân sự.</p>
            </div>

            <button @click="isEdit = false; formData = {id: null, employee_id: '', date: '', amount: '', reason: '', booking_id: ''}; showModal = true"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Ghi nhận Lỗi/Phạt
            </button>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-stone-100 shadow-sm relative z-10">
            <table class="min-w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-stone-50/80 border-b border-stone-100">
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Ngày</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Nhân sự</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-right">Số tiền phạt</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Lý do</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Show liên quan</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($deductions as $deduction)
                    <tr class="hover:bg-rose-50/30 transition-colors group">
                        <td class="p-4 text-stone-600 font-semibold text-sm">
                            {{ $deduction->date->format('d/m/Y') }}
                        </td>
                        <td class="p-4 font-extrabold text-stone-800 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-stone-200 to-stone-300 flex items-center justify-center text-stone-600 font-bold text-xs shadow-inner">
                                {{ mb_substr($deduction->employee->name, 0, 1) }}
                            </div>
                            {{ $deduction->employee->name }}
                        </td>
                        <td class="p-4 text-right">
                            <span class="inline-block bg-rose-50 text-rose-600 px-3 py-1.5 rounded-xl font-extrabold border border-rose-100 shadow-sm">
                                -{{ number_format($deduction->amount) }}<span class="text-[11px] ml-0.5 opacity-70">đ</span>
                            </span>
                        </td>
                        <td class="p-4 text-stone-600 font-medium">
                            <span class="block max-w-[200px] lg:max-w-xs truncate" title="{{ $deduction->reason }}">
                                {{ $deduction->reason }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($deduction->booking)
                                <span class="inline-flex items-center gap-1.5 bg-stone-100 text-stone-600 px-3 py-1 rounded-lg text-sm font-semibold border border-stone-200">
                                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    {{ $deduction->booking->customer_name }}
                                </span>
                            @else
                                <span class="text-stone-400 text-sm font-medium italic">Không gắn show</span>
                            @endif
                        </td>
                        <td class="p-4 flex justify-center gap-2">
                            <button @click="
                                    isEdit = true;
                                    formData = {
                                        id: {{ $deduction->id }},
                                        employee_id: @js($deduction->employee_id),
                                        date: @js($deduction->date->format('Y-m-d')),
                                        amount: @js($deduction->amount),
                                        reason: @js($deduction->reason),
                                        booking_id: @js($deduction->booking_id ?? '')
                                    };
                                    showModal = true"
                                    class="p-2 text-stone-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-colors" title="Chỉnh sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <form id="delete-deduction-form-{{ $deduction->id }}" action="{{ route('deductions.destroy', $deduction->id) }}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDeleteDeduction({{ $deduction->id }})" class="p-2 text-stone-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center">
                            <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-stone-50 text-stone-300 mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-stone-700 mb-1">Tuyệt vời!</h3>
                            <p class="text-sm text-stone-500">Chưa có bản ghi khấu trừ/phạt nào được ghi nhận.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> <template x-teleport="body">
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6">
            <div x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showModal = false"></div>

            <div x-show="showModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 border border-stone-100 max-h-[90vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                        <span class="bg-rose-100 text-rose-600 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </span>
                        <span x-text="isEdit ? 'Cập nhật Khấu trừ' : 'Ghi nhận Khấu trừ mới'"></span>
                    </h3>
                    <button type="button" @click="showModal = false" class="text-stone-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="isEdit ? '/deductions/' + formData.id : '{{ route('deductions.store') }}'" method="POST" class="space-y-5">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Nhân viên vi phạm <span class="text-rose-500">*</span></label>
                        <select name="employee_id" x-model="formData.employee_id" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium text-stone-800">
                            <option value="">-- Click để chọn nhân sự --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-stone-700 mb-1.5">Ngày vi phạm <span class="text-rose-500">*</span></label>
                            <input type="date" name="date" x-model="formData.date" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium text-stone-800">
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label class="block text-sm font-bold text-rose-600 mb-1.5">Số tiền phạt (VNĐ) <span class="text-rose-500">*</span></label>
                            <input type="number" min="0" step="1000" name="amount" x-model="formData.amount" placeholder="0" required class="w-full border-rose-200 rounded-xl p-3 bg-rose-50 text-rose-800 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-extrabold shadow-inner">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Lý do cụ thể <span class="text-rose-500">*</span></label>
                        <input type="text" name="reason" x-model="formData.reason" placeholder="VD: Đi trễ 30p, giao file chậm, làm hư thiết bị..." required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium text-stone-800">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Gắn với Show (Nếu có)</label>
                        <select name="booking_id" x-model="formData.booking_id" class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium text-stone-800">
                            <option value="">-- Không gắn liền với show nào --</option>
                            @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->shoot_date->format('d/m') }} - Khách: {{ $booking->customer_name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-stone-400 mt-2 font-medium"><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Tính năng này giúp bạn dễ dàng truy vết lại vi phạm xảy ra tại dự án nào.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showModal = false" class="px-6 py-3 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition shadow-sm">Hủy Bỏ</button>
                        <button type="submit" class="px-6 py-3 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-lg shadow-stone-900/20 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span x-text="isEdit ? 'Lưu Thay Đổi' : 'Xác Nhận Phạt'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div> </template>
</div> <style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>

<script>
    function confirmDeleteDeduction(id) {
        Swal.fire({
            title: 'Xóa khoản phạt này?',
            text: "Dữ liệu khấu trừ này sẽ bị xóa vĩnh viễn và không thể khôi phục!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // rose-600
            cancelButtonColor: '#a8a29e', // stone-400
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-deduction-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
