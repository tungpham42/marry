@extends('layouts.app')

@section('title', 'Lịch Chụp & Điều Phối')

@section('content')
<div x-data="{
        showAddModal: false,
        currentBooking: null,
        employeesData: {{ $employees }}
    }" class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-stone-800">Lịch Chụp & Điều Phối</h2>
            <p class="text-sm text-stone-500 mt-1">Quản lý show diễn, phân công nhân sự và ghi nhận ngày công.</p>
        </div>
        <button @click="showAddModal = true" class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md shadow-rose-500/20 hover:shadow-lg transition-all hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Thêm Lịch Mới
        </button>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-stone-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-stone-50/80 border-b border-stone-100">
                    <th class="p-4 font-bold text-stone-600 text-sm uppercase tracking-wider">Khách hàng</th>
                    <th class="p-4 font-bold text-stone-600 text-sm uppercase tracking-wider">Gói chụp</th>
                    <th class="p-4 font-bold text-stone-600 text-sm uppercase tracking-wider">Ngày chụp</th>
                    <th class="p-4 font-bold text-stone-600 text-sm uppercase tracking-wider">Ê-kíp</th>
                    <th class="p-4 font-bold text-stone-600 text-sm uppercase tracking-wider text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($bookings as $booking)
                <tr class="hover:bg-rose-50/30 transition-colors group">
                    <td class="p-4 font-bold text-stone-800">{{ $booking->customer_name }}</td>
                    <td class="p-4 text-stone-600 font-medium">{{ $booking->package->name }}</td>
                    <td class="p-4 text-stone-600 font-semibold">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $booking->shoot_date->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="p-4 text-sm">
                        <span class="bg-stone-100 text-stone-700 border border-stone-200 px-3 py-1 rounded-lg font-bold inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ $booking->employees->count() }} người
                        </span>
                    </td>
                    <td class="p-4 flex justify-center gap-2">

                        <form id="delete-booking-form-{{ $booking->id }}" action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="m-0">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDeleteBooking({{ $booking->id }})" class="p-2 text-stone-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="Xóa lịch">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>

                        <button @click="currentBooking = currentBooking === {{ $booking->id }} ? null : {{ $booking->id }}"
                                class="px-4 py-2 rounded-xl font-bold transition-all border shadow-sm flex items-center gap-2"
                                :class="{ 'bg-rose-600 text-white border-rose-600 shadow-rose-200': currentBooking === {{ $booking->id }}, 'bg-white text-stone-700 border-stone-200 hover:border-rose-300 hover:text-rose-600': currentBooking !== {{ $booking->id }} }">
                            <span>Điều phối</span>
                            <svg class="w-4 h-4 transition-transform" :class="currentBooking === {{ $booking->id }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </td>
                </tr>

                <tr x-show="currentBooking === {{ $booking->id }}" x-cloak class="bg-stone-50/50" x-transition
                    x-data="{ assignedIds: {{ $booking->employees->pluck('id') }} }">
                    <td colspan="5" class="p-0 border-b-2 border-rose-200 relative">
                        <div class="p-6 lg:p-8">
                            <button @click="currentBooking = null" class="absolute top-4 right-6 text-stone-400 hover:text-rose-500 transition p-2 rounded-full hover:bg-white" title="Đóng">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="flex-1">
                                    <h4 class="font-extrabold mb-6 text-stone-800 flex items-center gap-2 text-lg">
                                        <span class="bg-rose-100 text-rose-600 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span>
                                        Ê-kíp tham gia & Chấm công
                                    </h4>

                                    @if($booking->employees->count() == 0)
                                        <div class="flex flex-col items-center justify-center p-8 bg-white border-2 border-dashed border-stone-200 rounded-2xl text-center">
                                            <div class="bg-stone-100 p-3 rounded-full mb-3 text-stone-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <p class="text-stone-500 font-medium">Chưa có nhân sự nào được phân công vào show này.</p>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                                            @foreach($booking->employees as $emp)
                                            <div class="bg-white border-2 {{ $emp->pivot->status == 'completed' ? 'border-emerald-400 shadow-emerald-100/50' : 'border-transparent shadow-stone-200/50' }} shadow-lg rounded-2xl p-6 relative transition-all">

                                                @if($emp->pivot->status == 'completed')
                                                    <span class="absolute -top-3 -right-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-1 text-xs font-bold rounded-full shadow-md flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        Đã Chốt
                                                    </span>
                                                @else
                                                    <span class="absolute -top-3 -right-3 bg-gradient-to-r from-amber-400 to-orange-400 text-white px-4 py-1 text-xs font-bold rounded-full shadow-md">
                                                        Chờ Chốt
                                                    </span>
                                                @endif

                                                <div class="mb-5 border-b border-stone-100 pb-4">
                                                    <div class="text-xl font-extrabold text-stone-800">{{ $emp->name }}</div>
                                                    <div class="text-sm mt-1.5 flex items-center gap-2 text-stone-500 font-medium">
                                                        Vai trò: <span class="bg-rose-50 text-rose-600 px-2.5 py-0.5 rounded-md font-bold">{{ $emp->pivot->assigned_role }}</span>
                                                    </div>
                                                </div>

                                                <form action="{{ route('bookings.crew.update', [$booking->id, $emp->id]) }}" method="POST">
                                                    @csrf @method('PUT')

                                                    <div class="space-y-4">
                                                        <div class="flex gap-4">
                                                            <div class="w-1/3">
                                                                <label class="block text-xs font-bold text-stone-500 mb-1.5 uppercase tracking-wide">Giờ OT</label>
                                                                <div class="relative">
                                                                    <input type="number" min="0" step="0.5" name="ot_hours" value="{{ $emp->pivot->ot_hours }}" class="w-full border-stone-200 bg-stone-50 rounded-xl py-2 px-3 text-sm font-semibold focus:bg-white focus:border-rose-400 focus:ring-rose-400 transition" placeholder="0">
                                                                    <span class="absolute right-3 top-2.5 text-xs text-stone-400 font-medium">giờ</span>
                                                                </div>
                                                            </div>
                                                            <div class="w-2/3">
                                                                <label class="block text-xs font-extrabold text-rose-600 mb-1.5 uppercase tracking-wide">Công (Thực nhận)</label>
                                                                <div class="relative">
                                                                    <input type="number" min="0" step="0.1" name="credited_work_days" value="{{ $emp->pivot->credited_work_days }}" required
                                                                           class="w-full border-rose-200 bg-rose-50 text-rose-800 font-extrabold rounded-xl py-2 px-3 text-sm focus:bg-white focus:border-rose-500 focus:ring-rose-500 transition shadow-inner">
                                                                    <span class="absolute right-3 top-2.5 text-xs font-bold text-rose-400">ngày</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-stone-50 p-4 rounded-xl border border-stone-100">
                                                            <label class="block text-xs font-bold text-stone-500 mb-2 uppercase tracking-wide">Phụ cấp (Tiền & Ghi chú)</label>
                                                            <div class="flex gap-2">
                                                                <input type="number" min="0" name="allowance_amount" value="{{ $emp->pivot->allowance_amount }}" class="w-1/3 border-stone-200 rounded-lg py-2 px-3 text-sm font-semibold focus:border-rose-400 focus:ring-rose-400" placeholder="VNĐ">
                                                                <input type="text" name="allowance_note" value="{{ $emp->pivot->allowance_note }}" class="w-2/3 border-stone-200 rounded-lg py-2 px-3 text-sm focus:border-rose-400 focus:ring-rose-400" placeholder="Vd: Tiền xăng, ăn trưa...">
                                                            </div>
                                                        </div>

                                                        <div class="pt-3 flex justify-between items-center gap-3">
                                                            <button type="submit" class="flex-1 bg-stone-900 text-white font-bold py-2.5 rounded-xl hover:bg-stone-800 transition shadow-md flex justify-center items-center gap-2">
                                                                @if($emp->pivot->status == 'completed')
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Cập nhật lại
                                                                @else
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Chốt Công
                                                                @endif
                                                            </button>

                                                            <button type="button" onclick="confirmRemove({{ $booking->id }}, {{ $emp->id }})" class="text-stone-400 hover:text-red-500 hover:bg-red-50 p-2.5 rounded-xl border border-transparent hover:border-red-200 transition" title="Gỡ nhân sự">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <form id="remove-form-{{$booking->id}}-{{$emp->id}}" action="{{ route('bookings.crew.remove', [$booking->id, $emp->id]) }}" method="POST" class="hidden">
                                                    @csrf @method('DELETE')
                                                </form>

                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="w-full lg:w-1/3 xl:w-1/4">
                                    <div class="bg-white border-2 border-rose-100 rounded-2xl shadow-lg shadow-rose-100/50 p-6 sticky top-24">
                                        <h4 class="font-extrabold mb-5 text-stone-800 border-b border-stone-100 pb-3">Phân công nhân sự</h4>
                                        <form action="{{ route('bookings.crew.assign', $booking->id) }}" method="POST" class="space-y-4">
                                            @csrf

                                            <div>
                                                <label class="block text-sm font-bold text-stone-700 mb-1.5">Chọn người</label>
                                                <select name="employee_id" required class="w-full border-stone-200 rounded-xl py-2.5 px-3 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium bg-stone-50 focus:bg-white transition">
                                                    <option value="">-- Click để chọn --</option>
                                                    <template x-for="e in employeesData" :key="e.id">
                                                        <template x-if="!assignedIds.includes(e.id)">
                                                            <option :value="e.id" x-text="e.name + ' (' + e.primary_role + ')'"></option>
                                                        </template>
                                                    </template>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-stone-700 mb-1.5">Vai trò thực tế</label>
                                                <input list="roles-{{ $booking->id }}" name="assigned_role" required placeholder="Gõ hoặc chọn..." class="w-full border-stone-200 rounded-xl py-2.5 px-3 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium bg-stone-50 focus:bg-white transition">
                                                <datalist id="roles-{{ $booking->id }}">
                                                    <option value="Thợ chính">
                                                    <option value="Thợ phụ">
                                                    <option value="Quay phim">
                                                    <option value="M.U.A">
                                                    <option value="Trợ lý">
                                                </datalist>
                                                <p class="text-[11px] text-stone-400 mt-2 font-medium leading-tight">* Hệ thống sẽ tự động bốc số ngày công định mức từ gói chụp tương ứng.</p>
                                            </div>

                                            <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-amber-500 text-white font-bold py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 mt-2">
                                                + Thêm Vào Lịch
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
                    <td colspan="5" class="p-12 text-center">
                        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-stone-100 text-stone-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="text-xl font-bold text-stone-700">Chưa có lịch chụp nào.</div>
                        <div class="text-sm text-stone-500 mt-2">Hãy bấm "Thêm Lịch Mới" để tạo ngay show diễn đầu tiên.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <template x-teleport="body">
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
            <div x-show="showAddModal" x-transition.opacity class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="showAddModal = false"></div>

            <div x-show="showAddModal"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative z-10 mx-4 border border-stone-100">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-stone-800">Tạo Lịch Mới</h3>
                    <button @click="showAddModal = false" class="text-stone-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-full transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Tên khách hàng</label>
                        <input type="text" name="customer_name" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Gói chụp</label>
                        <select name="package_id" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium">
                            <option value="">-- Chọn gói dịch vụ --</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1.5">Ngày chụp</label>
                        <input type="date" name="shoot_date" required class="w-full border-stone-200 rounded-xl p-3 bg-stone-50 focus:bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 transition font-medium text-stone-700">
                    </div>

                    <input type="hidden" name="status" value="pending">

                    <div class="flex justify-end gap-3 pt-4 border-t border-stone-100 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 font-bold text-stone-500 bg-white border border-stone-200 rounded-xl hover:bg-stone-50 transition">Hủy</button>
                        <button type="submit" class="px-5 py-2.5 font-bold text-white bg-stone-900 rounded-xl hover:bg-stone-800 shadow-md transition">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

<script>
    // Existing Remove Employee Swal
    function confirmRemove(bookingId, empId) {
        Swal.fire({
            title: 'Gỡ nhân sự?',
            text: "Thao tác này sẽ xóa nhân sự khỏi danh sách thực hiện show.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Có, gỡ bỏ',
            cancelButtonText: 'Hủy',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`remove-form-${bookingId}-${empId}`).submit();
            }
        })
    }

    // New Delete Booking Swal
    function confirmDeleteBooking(bookingId) {
        Swal.fire({
            title: 'Xóa lịch chụp này?',
            text: "Toàn bộ dữ liệu ê-kíp và công của show này sẽ bị mất. Thao tác này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#a8a29e',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-booking-form-${bookingId}`).submit();
            }
        })
    }
</script>
@endsection
