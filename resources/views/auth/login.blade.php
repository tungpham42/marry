@extends('layouts.app')

@section('content')
<div class="flex min-h-[calc(100vh-10rem)] flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center mb-6">
            <div class="bg-gradient-to-tr from-rose-500 to-amber-500 text-white p-3 rounded-2xl shadow-lg shadow-rose-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
            </div>
        </div>
        <h2 class="text-center text-3xl font-extrabold tracking-tight text-stone-900">Đăng nhập hệ thống</h2>
        <p class="mt-2 text-center text-sm text-stone-500 font-medium">
            Chưa có tài khoản?
            <a href="{{ route('register') }}" class="font-bold text-rose-600 hover:text-rose-500 transition">Đăng ký ngay</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-2xl shadow-stone-200/50 sm:rounded-3xl sm:px-12 border border-stone-100">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-stone-700 mb-1.5">Địa chỉ Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-stone-700 mb-1.5">Mật khẩu</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-xl border-stone-200 bg-stone-50 py-3 px-4 text-stone-800 placeholder-stone-400 focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition font-medium">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-stone-300 text-rose-600 focus:ring-rose-500">
                        <label for="remember_me" class="ml-2 block text-sm font-medium text-stone-600">Ghi nhớ đăng nhập</label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-bold text-stone-600 hover:text-rose-600 transition">Quên mật khẩu?</a>
                        </div>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="flex w-full justify-center rounded-xl bg-gradient-to-r from-stone-900 to-stone-800 py-3 px-4 text-sm font-bold text-white shadow-lg hover:shadow-stone-400/50 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-stone-900 focus:ring-offset-2">
                        Đăng Nhập
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
