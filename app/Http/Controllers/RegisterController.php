<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        try {

            $user = User::create([
                'first_name' => $request->validated()['first_name'],
                'last_name' => $request->validated()['last_name'],
                'email' => $request->validated()['email'],
                'password' => Hash::make($request->validated()['password']),
                'status' => 0,
                // 'verification_token' => Str::random(60),
            ]);            
            
            Mail::to($user->email)->send(new WelcomeMail($user));

            //  Chuyển hướng về trang đăng nhập với thông báo thành công
            return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công!');
        } catch (\Exception $e) {
            //  Xử lý lỗi trong quá trình đăng ký
            return redirect()->route('register')->with('error', 'Có lỗi xảy ra trong quá trình đăng ký: ' . $e->getMessage());
        }
    }
}
