<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Hiển thị trang đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Xử lý logic đăng nhập
     */
    public function login(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        // Kiểm tra tính năng "Ghi nhớ đăng nhập"
        $remember = $request->has('remember');

        // 2. Xác thực thông tin người dùng
        if (Auth::attempt($credentials, $remember)) {
            // Khởi tạo lại session chống tấn công Session Fixation
            $request->session()->regenerate();

            // Chuyển hướng người dùng về trang họ định truy cập trước đó, hoặc mặc định về trang lịch chụp
            return redirect()->intended(route('bookings.index'))
                ->with('success', 'Chào mừng quay trở lại, ' . Auth::user()->name . '!');
        }

        // 3. Trả về lỗi nếu đăng nhập thất bại
        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email'));
    }

    /**
     * Hiển thị trang đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý logic đăng ký tài khoản mới
     */
    public function register(Request $request)
    {
        // 1. Validate dữ liệu đăng ký
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được sử dụng trên hệ thống.',
            'password.required' => 'Vui lòng tạo mật khẩu.',
            'password.min' => 'Mật khẩu độ dài tối thiểu phải từ 6 ký tự.',
            'password.confirmed' => 'Xác nhận lại mật khẩu không khớp.',
        ]);

        // 2. Tạo User mới trong cơ sở dữ liệu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Tự động đăng nhập cho thành viên mới
        Auth::login($user);

        // 4. Chuyển hướng về trang làm việc chính
        return redirect()->route('bookings.index')
            ->with('success', 'Đăng ký thành công! Chào mừng bạn đến với Studio Manager Pro.');
    }

    /**
     * Xử lý logic đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        // Đăng xuất tài khoản khỏi Guard hiện tại
        Auth::logout();

        // Xóa sạch session và tạo lại mã token bảo mật mới (CSRF Token)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Quay về trang login kèm thông báo
        return redirect()->route('login')
            ->with('success', 'Bạn đã đăng xuất khỏi hệ thống an toàn.');
    }
}
