<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if ($user->status === 0) {
                Auth::logout();
                return back()->with('error', 'Tài khoản đang chờ phê duyệt.');
            }

            if ($user->status === 2) {
                Auth::logout();
                return back()->with('error', 'Tài khoản bị từ chối.');
            }

            if ($user->status === 3) {
                Auth::logout();
                return back()->with('error', 'Tài khoản đã bị khóa.');
            }

            return redirect()->route('dashboard')->with('success', 'Đăng nhập thành công');
        }

        return back()->with('error', 'Thông tin đăng nhập không chính xác.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}


