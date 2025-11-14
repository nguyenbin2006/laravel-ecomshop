<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem User đã đăng nhập VÀ có phải là Admin không
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Cho phép đi tiếp
        }

        // Nếu không, đá về trang chủ
        return redirect('/');
        }
}
