<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Đăng xuất thành công');
    }

    private function redirectByRole()
    {
        $user = Auth::user();
        
        if ($user->role && $user->role->name === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role && $user->role->name === 'giang-vien') {
            return redirect()->intended('/giang-vien/dashboard');
        } elseif ($user->role && $user->role->name === 'sinh-vien') {
            return redirect()->intended('/sinh-vien/dashboard');
        }

        return redirect('/login');
    }
}
