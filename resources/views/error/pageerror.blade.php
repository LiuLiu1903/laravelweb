@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1 class="text-danger">Đã xảy ra lỗi</h1>
        <p>Trang bạn yêu cầu hiện không khả dụng.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Quay về trang chủ</a>
    </div>
@endsection
