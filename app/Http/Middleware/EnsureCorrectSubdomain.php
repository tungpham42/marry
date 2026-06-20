<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCorrectSubdomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost(); // vd: tung.marry.io.vn
        $baseDomain = 'marry.io.vn';

        if (Auth::check()) {
            $expectedHost = Auth::user()->subdomain . '.' . $baseDomain;

            // Nếu user đang ở trang chủ (marry.io.vn) hoặc sai subdomain, ép chuyển hướng về đúng nhà của họ
            if ($host !== $expectedHost) {
                return redirect()->to('https://' . $expectedHost . $request->getRequestUri());
            }
        }

        return $next($request);
    }
}
