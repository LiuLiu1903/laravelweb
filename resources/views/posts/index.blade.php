@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Hiển thị thông báo - Đặt ở đầu trang -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h2>Bài Viết của Bạn</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Thêm bài viết mới</a>

        @if ($posts->count() > 0)
            @foreach ($posts as $post)
                <div class="card mb-3">
                    <div class="row g-0">
                        @if ($post->hasMedia('thumbnails'))
                            <div class="col-md-3">
                                <img src="{{ $post->getFirstMediaUrl('thumbnails') }}" class="img-fluid rounded-start h-100"
                                    style="object-fit: cover; max-height: 200px;" alt="Thumbnail">
                            </div>
                        @else
                            <div class="col-md-3 bg-light d-flex align-items-center justify-content-center">
                                <span class="text-muted">Không có ảnh</span>
                            </div>
                        @endif

                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ Str::limit($post->description, 200) }}</p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Trạng thái:
                                        <span
                                            class="badge {{ $post->status == 2 ? 'bg-success' : ($post->status == 1 ? 'bg-warning' : 'bg-primary') }}">
                                            {{ $post->status == 2 ? 'Xuất bản' : ($post->status == 1 ? 'Được cập nhật' : 'Bài viết mới') }}
                                        </span>
                                        •
                                        Ngày tạo: {{ $post->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </p>

                                <div class="btn-group" role="group">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->slug) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Bạn chưa có bài viết nào
            </div>
        @endif
    </div>
@endsection

@section('styles')
    <!-- Thêm Font Awesome nếu chưa có -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-group .btn {
            margin-right: 5px;
        }
    </style>
@endsection
