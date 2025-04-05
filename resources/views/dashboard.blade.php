@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Màn hình Danh sách bài viết</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Tạo mới</a>
</div>
@endsection