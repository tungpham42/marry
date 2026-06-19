@extends('layouts.app')

@section('title', 'Bảng Tổng Hợp Lương')

@section('content')
<div class="bg-white rounded-3xl shadow-xl shadow-stone-200/40 p-6 lg:p-8 border border-stone-100 animate-fade-in-up">

    <!-- Header & Action (Giữ nguyên giao diện xịn xò) -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8 border-b border-stone-100 pb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-stone-800 flex items-center gap-3">
                <span class="bg-emerald-100 text-emerald-600 p-2.5 rounded-2xl shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                Bảng Tổng Hợp Lương
            </h2>
            <p class="text-sm font-medium text-stone-500 mt-2 ml-1">Kỳ chốt công tháng <span class="text-rose-600 font-extrabold text-base">{{ $month }}/{{ $year }}</span></p>
        </div>

        <form action="{{ route('payrolls.generate') }}" method="POST" class="w-full lg:w-auto">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">
            <button type="submit" class="w-full lg:w-auto bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18"></path></svg>
                Chạy & Tính Lại Lương Tháng Này
            </button>
        </form>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('payrolls.index') }}" class="mb-8 flex flex-col sm:flex-row items-end gap-4 bg-stone-50/80 p-5 rounded-2xl border border-stone-100 shadow-inner">
        <div class="w-full sm:w-32">
            <label class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-2">Chọn Tháng</label>
            <input type="number" name="month" min="1" max="12" step="1" value="{{ (int)$month }}" class="w-full border-stone-200 bg-white rounded-xl py-3 px-3 text-center text-stone-800 font-extrabold focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 shadow-sm transition">
        </div>
        <div class="w-full sm:w-32">
            <label class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-2">Chọn Năm</label>
            <input type="number" name="year" min="2020" step="1" value="{{ (int)$year }}" class="w-full border-stone-200 bg-white rounded-xl py-3 px-3 text-center text-stone-800 font-extrabold focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 shadow-sm transition">
        </div>
        <button type="submit" class="w-full sm:w-auto bg-stone-900 text-white px-8 py-3 rounded-xl hover:bg-stone-800 font-bold transition shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Tra cứu
        </button>
    </form>

    @if($payrolls->isEmpty())
        <div class="text-center p-12 bg-white border-2 border-dashed border-stone-200 rounded-3xl">
            <div class="inline-flex justify-center items-center w-20 h-20 rounded-3xl bg-stone-50 text-stone-300 mb-5 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-extrabold text-stone-800 mb-2">Chưa có dữ liệu lương tháng này</h3>
            <p class="text-stone-500 font-medium">Hãy bấm nút <strong class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Chạy & Tính Lại Lương</strong> ở phía trên để hệ thống tự động tổng hợp.</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-2xl border border-stone-100 shadow-sm min-h-[300px]"> <!-- Thêm min-h để Dropdown không bị che -->
            <table class="min-w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-stone-50/80 border-b border-stone-100">
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider">Nhân sự</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Tổng Công</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-right">Lương Cơ Bản</th>
                        <th class="p-4 font-bold text-emerald-600 text-xs uppercase tracking-wider text-right bg-emerald-50/30">+ Thưởng/PC</th>
                        <th class="p-4 font-bold text-rose-600 text-xs uppercase tracking-wider text-right bg-rose-50/30">- Phạt/Khấu Trừ</th>
                        <th class="p-4 font-extrabold text-stone-800 text-sm uppercase tracking-wider text-right bg-stone-100/50">Thực Lĩnh</th>
                        <th class="p-4 font-bold text-stone-600 text-xs uppercase tracking-wider text-center">Cập Nhật Trạng Thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($payrolls as $pr)
                    <tr class="hover:bg-rose-50/40 transition-colors group">
                        <td class="p-4 font-extrabold text-stone-800 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-stone-200 to-stone-300 flex items-center justify-center text-stone-600 font-bold text-xs shadow-inner">
                                {{ mb_substr($pr->employee->name, 0, 1) }}
                            </div>
                            {{ $pr->employee->name }}
                        </td>
                        <td class="p-4 text-center">
                            <span class="bg-stone-100 text-stone-700 px-3 py-1 rounded-lg font-extrabold border border-stone-200">
                                {{ $pr->total_work_days }}
                            </span>
                        </td>
                        <td class="p-4 text-right text-stone-500 font-bold">
                            {{ number_format($pr->salary_by_days) }}<span class="text-xs ml-0.5 text-stone-400">đ</span>
                        </td>
                        <td class="p-4 text-right text-emerald-600 font-bold bg-emerald-50/10">
                            + {{ number_format($pr->total_allowance) }}<span class="text-xs ml-0.5 opacity-70">đ</span>
                        </td>
                        <td class="p-4 text-right text-rose-500 font-bold bg-rose-50/10">
                            - {{ number_format($pr->total_deduction) }}<span class="text-xs ml-0.5 opacity-70">đ</span>
                        </td>
                        <td class="p-4 text-right bg-stone-50/30 group-hover:bg-transparent transition-colors">
                            <span class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600 drop-shadow-sm">
                                {{ number_format($pr->final_salary) }}<span class="text-sm ml-0.5 text-teal-600/70">đ</span>
                            </span>
                        </td>

                        <!-- CỘT TRẠNG THÁI (ĐÃ UPDATE THÀNH DROPDOWN ALPINE.JS) -->
                        <td class="p-4 text-center relative">
                            @php
                                $status = strtolower($pr->status);
                                $badgeClasses = match($status) {
                                    'paid' => 'bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 border-emerald-200 hover:shadow-emerald-200/50',
                                    'approved' => 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border-blue-200 hover:shadow-blue-200/50',
                                    default => 'bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 border-amber-200 hover:shadow-amber-200/50',
                                };
                                $statusText = match($status) {
                                    'paid' => 'Đã chi trả',
                                    'approved' => 'Đã duyệt',
                                    default => 'Nháp (Tạm tính)',
                                };
                            @endphp

                            <div x-data="{ open: false }" class="inline-block relative text-left">
                                <button @click="open = !open" @click.outside="open = false"
                                        class="px-4 py-1.5 border text-xs font-extrabold rounded-xl tracking-wide inline-flex items-center gap-1.5 shadow-sm transition-all hover:scale-105 {{ $badgeClasses }}">
                                    {{ $statusText }}
                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <!-- Bảng chọn trạng thái thả xuống (Glassmorphism) -->
                                <div x-show="open" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                     class="absolute right-1/2 translate-x-1/2 z-50 mt-2 w-44 rounded-2xl bg-white/90 backdrop-blur-xl border border-white/60 p-1.5 shadow-[0_15px_40px_rgb(0,0,0,0.15)]">
                                    <form action="{{ route('payrolls.status', $pr->id) }}" method="POST" class="flex flex-col gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="status" value="draft" class="w-full text-left px-3 py-2 text-xs font-bold rounded-xl hover:bg-amber-50 text-amber-700 transition-colors {{ $status === 'draft' ? 'bg-amber-50/50' : '' }}">
                                            Tạm tính (Nháp)
                                        </button>
                                        <button type="submit" name="status" value="approved" class="w-full text-left px-3 py-2 text-xs font-bold rounded-xl hover:bg-blue-50 text-blue-700 transition-colors {{ $status === 'approved' ? 'bg-blue-50/50' : '' }}">
                                            Đã duyệt chốt
                                        </button>
                                        <button type="submit" name="status" value="paid" class="w-full text-left px-3 py-2 text-xs font-bold rounded-xl hover:bg-emerald-50 text-emerald-700 transition-colors {{ $status === 'paid' ? 'bg-emerald-50/50' : '' }}">
                                            Đã thanh toán (Paid)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .animate-spin-slow { animation: spin 3s linear infinite; }
</style>
@endsection
