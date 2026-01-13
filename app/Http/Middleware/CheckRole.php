<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }

        $user = Auth::user();
        
        if (!$user->role) {
            Auth::logout();
            return redirect('/login')->with('error', 'Tài khoản chưa được phân quyền');
        }

        // Kiểm tra role
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        return $next($request);
    }
}
