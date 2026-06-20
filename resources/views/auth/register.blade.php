@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="flex min-h-[calc(100vh-10rem)] flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-4 text-center text-3xl font-extrabold tracking-tight text-stone-900">Tạo tài khoản mới</h2>
        <p class="mt-2 text-center text-sm text-stone-500 font-medium">
            Đã có tài khoản?
            <a href="{{ route('login') }}" class="font-bold text-rose-600 hover:text-rose-500 transition">Đăng nhập tại đây</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-2xl shadow-stone-200/50 sm:rounded-3xl sm:px-12 border border-stone-100">
            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-stone-700 mb-1.5">Họ và tên</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-stone-700 mb-1.5">Địa chỉ Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div>
                    <label for="subdomain" class="block text-sm font-bold text-stone-700 mb-1.5">Tên miền Studio của bạn</label>
                    <div class="mt-1 flex rounded-xl shadow-sm">
                        <input id="subdomain" name="subdomain" type="text" required value="{{ old('subdomain') }}"
                            class="block w-full rounded-l-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium"
                            placeholder="ví dụ: tung">
                        <span class="inline-flex items-center rounded-r-xl border border-l-0 border-stone-200 bg-stone-100 px-4 text-stone-500 font-bold text-sm">
                            .marry.io.vn
                        </span>
                    </div>
                    @error('subdomain')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-stone-700 mb-1.5">Mật khẩu</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-stone-700 mb-1.5">Xác nhận mật khẩu</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="flex w-full justify-center rounded-xl bg-gradient-to-r from-rose-500 to-amber-500 py-3 px-4 text-sm font-bold text-white shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                        Hoàn Tất Đăng Ký
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
