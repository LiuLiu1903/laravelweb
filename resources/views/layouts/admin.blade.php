{{-- resources/views/layouts/admin.blade.php --}}
@extends('adminlte::page')

@section('title', 'Trang quản trị')

@section('content_header')
    <h1>@yield('page-title', 'Trang quản trị')</h1>
@endsection

@section('content')
    @yield('content-admin')
@endsection
