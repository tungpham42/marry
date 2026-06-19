<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | @yield('site_name', 'Studio Manager Pro')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title') | @yield('site_name', 'Studio Manager Pro')">
    <meta property="og:description" content="@yield('meta_description', 'Studio Manager Pro - Wedding Planner')">
    <meta property="og:image" content="@yield('og_image', asset('img/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Studio Manager Pro')">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    animation: {
                        'gradient-x': 'gradient-x 10s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': { 'background-size': '200% 200%', 'background-position': 'left center' },
                            '50%': { 'background-size': '200% 200%', 'background-position': 'right center' },
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'blob': {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #f8fafc; overflow-x: hidden; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* SweetAlert2 Glassmorphism */
        div:where(.swal2-container) div:where(.swal2-popup) {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            border-radius: 24px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important;
            padding: 1.5rem !important;
        }
    </style>
</head>
<body class="text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-rose-500 selection:text-white relative" x-data="{ mobileMenu: false }">

    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-rose-400/20 rounded-full mix-blend-multiply filter blur-[100px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[35vw] h-[35vw] bg-amber-300/20 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[45vw] h-[45vw] bg-violet-400/20 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-4000"></div>
    </div>

    <header class="fixed top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50">
        <nav class="bg-white/70 backdrop-blur-2xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-full px-4 sm:px-6 py-2.5 transition-all duration-500 hover:shadow-[0_8px_30px_rgb(225,29,72,0.1)]">
            <div class="flex items-center justify-between h-12">

                <div class="flex items-center gap-8">
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div class="bg-gradient-to-tr from-rose-500 via-fuchsia-500 to-amber-500 text-white p-2 rounded-full shadow-lg shadow-rose-500/30 group-hover:rotate-12 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        </div>
                        <span class="text-lg font-black tracking-widest bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">STUDIO<span class="text-rose-500">PRO</span></span>
                    </a>

                    @auth
                    <div class="hidden lg:flex items-center space-x-1 bg-slate-100/50 rounded-full p-1 border border-slate-200/50">
                        <a href="{{ route('bookings.index') }}" class="text-slate-600 hover:text-slate-900 hover:bg-white px-4 py-1.5 rounded-full text-sm font-bold transition-all shadow-sm shadow-transparent hover:shadow-slate-200/50">Lịch Chụp</a>
                        <a href="{{ route('packages.index') }}" class="text-slate-600 hover:text-slate-900 hover:bg-white px-4 py-1.5 rounded-full text-sm font-bold transition-all shadow-sm shadow-transparent hover:shadow-slate-200/50">Gói Chụp</a>
                        <a href="{{ route('employees.index') }}" class="text-slate-600 hover:text-slate-900 hover:bg-white px-4 py-1.5 rounded-full text-sm font-bold transition-all shadow-sm shadow-transparent hover:shadow-slate-200/50">Nhân Sự</a>
                        <a href="{{ route('roles.index') }}" class="text-slate-600 hover:text-slate-900 hover:bg-white px-4 py-1.5 rounded-full text-sm font-bold transition-all shadow-sm shadow-transparent hover:shadow-slate-200/50">Vai Trò</a>
                        <a href="{{ route('deductions.index') }}" class="text-slate-600 hover:text-slate-900 hover:bg-white px-4 py-1.5 rounded-full text-sm font-bold transition-all shadow-sm shadow-transparent hover:shadow-slate-200/50">Phạt/Lỗi</a>
                        <a href="{{ route('payrolls.index') }}" class="ml-1 relative group overflow-hidden bg-slate-900 text-white px-5 py-1.5 rounded-full text-sm font-bold shadow-md hover:scale-105 transition-all">
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-500 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative z-10">Chốt Lương</span>
                        </a>
                    </div>
                    @endauth
                </div>

                <div class="hidden md:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900 px-4 py-2 text-sm font-bold transition-colors">Đăng nhập</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="relative inline-flex h-10 overflow-hidden rounded-full p-[2px] focus:outline-none hover:scale-105 transition-transform">
                                <span class="absolute inset-[-1000%] animate-[spin_2s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#E2CBFF_0%,#393BB2_50%,#E2CBFF_100%)]"></span>
                                <span class="inline-flex h-full w-full cursor-pointer items-center justify-center rounded-full bg-slate-900 px-6 py-1 text-sm font-bold text-white backdrop-blur-3xl">
                                    Đăng ký
                                </span>
                            </a>
                        @endif
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2.5 rounded-full bg-white border border-slate-200/80 pl-2 pr-4 py-1.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rose-400 to-orange-400 text-white flex items-center justify-center text-xs shadow-inner">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95" class="absolute right-0 z-50 mt-4 w-56 origin-top-right rounded-3xl bg-white/90 backdrop-blur-xl border border-white/60 p-2 shadow-[0_20px_40px_rgb(0,0,0,0.1)]">
                                <div class="px-4 py-3 border-b border-slate-100 mb-2">
                                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Tài khoản</p>
                                    <p class="text-sm font-extrabold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-4 py-2.5 text-left text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="flex md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="inline-flex items-center justify-center rounded-full p-2 text-slate-600 hover:bg-slate-100 transition focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="mobileMenu ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 7h16M4 12h16m-7 5h7" />
                            <path :class="mobileMenu ? 'inline-flex' : 'hidden'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden mt-4 bg-white/90 backdrop-blur-2xl border border-white/60 rounded-3xl overflow-y-auto max-h-[calc(100vh-8rem)] shadow-2xl mx-2">
            <div class="space-y-1.5 px-4 pb-6 pt-4">
                @auth
                    <a href="{{ route('bookings.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition">Lịch Chụp & Điều Phối</a>
                    <a href="{{ route('packages.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition">Gói Chụp</a>
                    <a href="{{ route('employees.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition">Nhân Sự</a>
                    <a href="{{ route('roles.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition">Vai Trò</a>
                    <a href="{{ route('deductions.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 hover:bg-slate-50 transition">Quản Lý Phạt</a>
                    <a href="{{ route('payrolls.index') }}" class="block rounded-2xl px-4 py-3 text-base font-bold bg-slate-900 text-white text-center shadow-lg shadow-slate-900/20 mt-2">Chốt Lương</a>

                    <div class="mt-6 border-t border-slate-100 pt-4 px-2">
                        <div class="text-xs text-slate-400 font-bold uppercase mb-1">Đang đăng nhập</div>
                        <div class="font-black text-slate-800 text-lg mb-4">{{ Auth::user()->name }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center rounded-2xl py-3 text-base font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition">Đăng xuất</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block rounded-2xl px-4 py-3 text-base font-bold text-slate-700 bg-slate-50 text-center mb-2">Đăng nhập</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block rounded-2xl px-4 py-3 text-base font-bold bg-slate-900 text-white text-center shadow-lg shadow-slate-900/20">Đăng ký</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-32 pb-12 relative z-10">
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-slate-200/50 bg-white/30 backdrop-blur-md py-6 text-center text-sm font-semibold text-slate-400 relative z-10">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                &copy; {{ date('Y') }} <span class="text-slate-800 font-black tracking-wide">STUDIO PRO</span>. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                customClass: { popup: 'backdrop-blur-xl bg-white/80 border border-white/50 shadow-2xl rounded-2xl' },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: '{!! session("success") !!}' });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{!! session("error") !!}',
                    confirmButtonColor: '#e11d48',
                    customClass: {
                        popup: 'rounded-[2rem] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl',
                        confirmButton: 'rounded-xl font-bold px-8 py-3'
                    }
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Dữ liệu chưa hợp lệ',
                    html: `
                        <div class="text-left bg-rose-50/50 backdrop-blur-sm p-4 rounded-2xl border border-rose-100/50 mt-4">
                            <ul class="text-sm text-rose-600 list-disc pl-5 space-y-1.5 font-semibold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    confirmButtonColor: '#e11d48',
                    customClass: {
                        popup: 'rounded-[2rem] bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl',
                        confirmButton: 'rounded-xl font-bold px-8 py-3'
                    }
                });
            @endif
        });
    </script>
</body>
</html>
