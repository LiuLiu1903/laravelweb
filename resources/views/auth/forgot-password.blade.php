@extends('layouts.master')

@section('content')
<style>
    .alert-message {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        color: white;
        background-color: #28a745;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .forgot-password-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f9f9f9;
    }
    .forgot-password-form {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }
    .forgot-password-form input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .forgot-password-form button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }
    .forgot-password-form button:hover {
        background-color: #0056b3;
    }
    .forgot-password-form .error-message {
        color: red;
        font-size: 14px;
        text-align: left;
        margin-top: -5px;
        margin-bottom: 10px;
    }
</style>

<div class="forgot-password-container">
    <form method="POST" action="{{ route('password.email') }}" class="forgot-password-form">
        @csrf

        <!-- Hiển thị thông báo thành công -->
        @if (session('status'))
            <div class="alert-message">
                {{ session('status') }}
            </div>
        @endif

        <h2>Quên mật khẩu</h2>
        <p>Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>

        <!-- Input email -->
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" required />
        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <button type="submit">Gửi link đặt lại mật khẩu</button>
    </form>
</div>
@endsection