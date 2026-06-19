@extends('layouts.app')

@section('content')
<div class="space-y-10 animate-fade-in-up">

    <!-- Hero Section: Glassmorphism + Animated Gradient -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-900 border border-slate-800 shadow-[0_20px_50px_rgba(0,0,0,0.3)] p-8 sm:p-14 lg:p-20 text-white flex items-center justify-between group">

        <!-- Animated Mesh Background INSIDE Hero -->
        <div class="absolute inset-0 opacity-40 mix-blend-screen overflow-hidden pointer-events-none">
            <div class="absolute -top-[50%] -left-[10%] w-[80%] h-[150%] bg-gradient-to-r from-rose-500 via-fuchsia-600 to-orange-500 rounded-full blur-[120px] animate-gradient-x"></div>
        </div>

        <!-- Noise Texture overlay -->
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 mix-blend-overlay"></div>

        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl text-rose-200 text-sm font-bold mb-8 shadow-inner">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                </span>
                Pro Studio Engine 2026
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tight leading-[1.1]">
                Nền tảng quản trị <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 via-fuchsia-400 to-amber-300 animate-gradient-x drop-shadow-sm">
                    Studio Tương Lai.
                </span>
            </h1>

            <p class="text-slate-300 text-lg md:text-xl font-medium leading-relaxed max-w-2xl">
                Tự động hóa mọi quy trình từ xếp lịch, phân bổ ê-kíp đến chốt lương chính xác tuyệt đối. Giải phóng không gian sáng tạo của bạn.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('bookings.index') }}" class="px-8 py-4 rounded-full bg-white text-slate-900 font-black text-sm md:text-base hover:scale-105 transition-transform shadow-[0_0_40px_rgba(255,255,255,0.3)]">
                    Mở Lịch Trình Ngay
                </a>
                <a href="{{ route('payrolls.index') }}" class="px-8 py-4 rounded-full bg-white/10 text-white font-bold text-sm md:text-base border border-white/20 backdrop-blur-md hover:bg-white/20 transition-colors">
                    Xem Bảng Lương
                </a>
            </div>
        </div>

        <!-- 3D Floating Element -->
        <div class="hidden lg:block relative z-10 transform group-hover:scale-110 group-hover:-rotate-3 transition duration-700 animate-float">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-400 to-fuchsia-600 rounded-[2.5rem] blur-2xl opacity-40"></div>
                <div class="p-8 bg-white/10 backdrop-blur-2xl rounded-[2.5rem] border border-white/20 shadow-2xl relative z-10">
                    <svg class="w-32 h-32 text-white drop-shadow-xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <circle cx="12" cy="13" r="3" stroke-width="1.5"></circle>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Title Separator -->
    <div class="flex items-center justify-center gap-4 mt-16 mb-8">
        <div class="h-px bg-gradient-to-r from-transparent to-slate-200 flex-1"></div>
        <h2 class="text-xl font-black text-slate-800 uppercase tracking-widest px-4 text-center">Bảng Điều Khiển Lối Tắt</h2>
        <div class="h-px bg-gradient-to-l from-transparent to-slate-200 flex-1"></div>
    </div>

    <!-- Bento Grid Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

        <!-- Bento Card 1: Bookings -->
        <a href="{{ route('bookings.index') }}" class="group relative block bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-rose-200 transition-all duration-500 overflow-hidden hover:-translate-y-2">
            <!-- Hover Glow Effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <!-- Large Icon background -->
            <div class="absolute -top-6 -right-6 opacity-[0.03] group-hover:opacity-10 group-hover:rotate-12 transition-all duration-700 transform scale-150 group-hover:scale-110">
                <svg class="w-48 h-48 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>

            <div class="relative z-10">
                <div class="bg-gradient-to-br from-rose-100 to-rose-50 text-rose-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-rose-500 group-hover:to-rose-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-rose-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3 group-hover:text-rose-600 transition-colors">Lịch Chụp Show</h3>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Điều phối ê-kíp, phân lịch khách hàng, kiểm soát OT trực quan.</p>

                <div class="mt-6 flex items-center text-xs font-bold text-rose-600 opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all duration-300">
                    Truy cập ngay <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>
        </a>

        <!-- Bento Card 2: Employees -->
        <a href="{{ route('employees.index') }}" class="group relative block bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-amber-200 transition-all duration-500 overflow-hidden hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -top-6 -right-6 opacity-[0.03] group-hover:opacity-10 group-hover:rotate-12 transition-all duration-700 transform scale-150 group-hover:scale-110">
                <svg class="w-48 h-48 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>

            <div class="relative z-10">
                <div class="bg-gradient-to-br from-amber-100 to-amber-50 text-amber-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-amber-400 group-hover:to-amber-500 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-amber-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3 group-hover:text-amber-600 transition-colors">Quản Lý Nhân Sự</h3>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Hồ sơ Database thợ ảnh, makeup, lương cơ bản và tracking nhân sự.</p>

                <div class="mt-6 flex items-center text-xs font-bold text-amber-600 opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all duration-300">
                    Truy cập ngay <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>
        </a>

        <!-- Bento Card 3: Packages -->
        <a href="{{ route('packages.index') }}" class="group relative block bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-violet-200 transition-all duration-500 overflow-hidden hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -top-6 -right-6 opacity-[0.03] group-hover:opacity-10 group-hover:rotate-12 transition-all duration-700 transform scale-150 group-hover:scale-110">
                <svg class="w-48 h-48 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>

            <div class="relative z-10">
                <div class="bg-gradient-to-br from-violet-100 to-violet-50 text-violet-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gradient-to-br group-hover:from-violet-500 group-hover:to-violet-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-violet-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3 group-hover:text-violet-600 transition-colors">Gói Dịch Vụ</h3>
                <p class="text-sm font-medium text-slate-500 leading-relaxed">Lên báo giá, định nghĩa gói chụp và auto-set định mức công.</p>

                <div class="mt-6 flex items-center text-xs font-bold text-violet-600 opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all duration-300">
                    Truy cập ngay <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>
        </a>

        <!-- Bento Card 4: Payrolls (Highlight Card) -->
        <a href="{{ route('payrolls.index') }}" class="group relative block bg-slate-900 p-8 rounded-[2rem] shadow-xl shadow-slate-900/10 hover:shadow-teal-500/20 transition-all duration-500 overflow-hidden hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute -top-6 -right-6 opacity-[0.05] group-hover:opacity-15 group-hover:rotate-12 transition-all duration-700 transform scale-150 group-hover:scale-110">
                <svg class="w-48 h-48 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <div class="relative z-10">
                <div class="bg-gradient-to-br from-teal-400 to-emerald-500 text-white w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-teal-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-white mb-3 group-hover:text-teal-400 transition-colors">Chốt Lương Tự Động</h3>
                <p class="text-sm font-medium text-slate-400 leading-relaxed">Thuật toán tổng hợp công, phụ cấp, OT và xuất bảng lương một chạm.</p>

                <div class="mt-6 flex items-center text-xs font-bold text-teal-400 opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all duration-300">
                    Thực hiện ngay <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </div>
        </a>

    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endsection
