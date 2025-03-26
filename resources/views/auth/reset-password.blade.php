@extends('layouts.master')

@section('content')
<style>
    .reset-password-container {
        max-width: 400px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .reset-password-container h1 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }
    .email-display {
        padding: 0.75rem;
        margin-bottom: 1.5rem;
        background: #f8f9fa;
        border-radius: 4px;
        border-left: 4px solid #007bff;
        word-break: break-all;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    .error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
    button[type="submit"] {
        width: 100%;
        padding: 0.75rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 1rem;
    }
</style>

<div class="reset-password-container">
    <h1>Đặt lại mật khẩu</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        {{-- Xử lý hiển thị email từ request --}}
        @php
            $email = request()->email ?? old('email');
        @endphp
        
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="email-display">
            <strong>Email:</strong> {{ $email }}
        </div>
        
        <div class="form-group">
            <label>Mật khẩu mới</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu mới" required />
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required />
        </div>
        
        <button type="submit">Đặt lại mật khẩu</button>
    </form>
</div>
@endsection