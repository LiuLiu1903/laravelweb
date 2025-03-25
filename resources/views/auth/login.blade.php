@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Sign In</h3>

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

        <form action="{{ route('login') }}" method="POST">
            @csrf
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

            <!-- Remember Me -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
        </form>

        <!-- Link Hỗ Trợ -->
        {{-- <div class="text-center mt-3">
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        </div> --}}
        <div class="text-center mt-2">
            Don't have an account? 
            <a href="{{ route('register') }}" class="fw-bold">Register here</a>
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
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script>
        // Automatically close the alert after 5 seconds
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);

        // Close the alert when any key is pressed
        document.addEventListener('keydown', function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    </script> --}}
@endpush