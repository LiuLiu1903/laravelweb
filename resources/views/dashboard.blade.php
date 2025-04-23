@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="row mt-4">
        @forelse ($posts as $post)
            <div class="col-12 mb-4">
                <div class="card h-100">
                    {{-- Ảnh bài viết --}}
                    <div class="text-center" style="height: 250px; overflow: hidden;">
                        @if ($post->getFirstMediaUrl('thumbnails'))
                            <img src="{{ $post->getFirstMediaUrl('thumbnails') }}" 
                                 alt="{{ $post->title }}" 
                                 class="img-fluid h-100 w-auto rounded" 
                                 style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                Không có ảnh
                            </div>
                        @endif
                    </div>

                    {{-- Nội dung --}}
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                        <p class="text-muted mb-2">
                            <small>Ngày tạo: {{ $post->created_at->format('d/m/Y') }}</small>
                        </p>
                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary btn-sm mt-auto">
                            Xem chi tiết
                        </a>
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

    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
