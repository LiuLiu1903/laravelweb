@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center mb-4">Register</h3>

        <!-- Thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Thông báo lỗi -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Thông báo lỗi từ validator -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- First Name -->
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <div class="input-group">
                    <input type="text" name="first_name" id="first_name" 
                        class="form-control @error('first_name') is-invalid @enderror" 
                        placeholder="First Name" required value="{{ old('first_name') }}">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                @error('first_name')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <div class="input-group">
                    <input type="text" name="last_name" id="last_name" 
                        class="form-control @error('last_name') is-invalid @enderror" 
                        placeholder="Last Name" required value="{{ old('last_name') }}">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                @error('last_name')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="Email" required value="{{ old('email') }}">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Password" required>
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="form-control" placeholder="Confirm Password" required>
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="terms" id="terms" 
                    class="form-check-input @error('terms') is-invalid @enderror" required>
                <label for="terms" class="form-check-label">I agree to the terms and conditions</label>
                @error('terms')
                    <div class="text-danger fw-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>

        <div class="text-center mt-3">
            Already have an account? 
            <a href="{{ route('login') }}" class="fw-bold">Login here</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="/template/plugins/jquery/jquery.min.js"></script>
@endpush