@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Brick: Ảnh tiêu đề --}}
    @if ($post->getFirstMediaUrl('thumbnails'))
        <div class="brick mb-4 text-center">
            <img src="{{ $post->getFirstMediaUrl('thumbnails') }}"
                 alt="{{ $post->title }}"
                 class="img-fluid rounded"
                 style="max-height: 350px; object-fit: cover;">
        </div>
    @endif

    {{-- Brick: Tiêu đề + Ngày --}}
    <div class="brick mb-4">
        <h1 class="fw-bold">{{ $post->title }}</h1>
        <hr>
        <p class="text-muted">
            <i class="far fa-calendar-alt"></i>
            {{ $post->publish_date ? $post->publish_date->format('d/m/Y H:i') : 'Chưa có ngày xuất bản' }}
        </p>
    </div>

    {{-- Brick: Mô tả --}}
    <div class="brick mb-4">
        <h5 class="text-secondary mb-2">Mô tả</h5>
        <p class="lead">{{ $post->description }}</p>
    </div>

    {{-- Brick: Nội dung chính --}}
    <div class="brick mb-4 post-content">
        <h5 class="text-secondary mb-2">Nội dung chi tiết</h5>
        <hr>
        {!! $post->content !!}
    </div>

</div>
@endsection

@push('styles')
<style>
    .brick {
        background-color: #ffffff;
        border: 1px solid #e3e3e3;
        border-left: 4px solid #0d6efd;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .brick hr {
        border-top: 1px dashed #ccc;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .post-content p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }

    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 10px 0;
    }
</style>
@endpush
