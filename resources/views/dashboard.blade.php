@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="row mt-4">
        @forelse ($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    {{-- Hiển thị ảnh bài viết --}}
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Ảnh bài viết" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="No image">
                    @endif

                    <div class="card-body">
                        {{-- Mô tả --}}
                        <p class="card-text">{{ Str::limit($post->description, 100) }}</p>

                        {{-- Ngày tạo --}}
                        <p class="text-muted mb-2">
                            <small>Ngày tạo: {{ $post->created_at->format('d/m/Y') }}</small>
                        </p>

                        {{-- Link tới bài viết --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Không có bài viết nào được duyệt.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
