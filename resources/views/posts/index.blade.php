@extends('layouts.app')

@section('content')
    @if (session('success'))
        <script>alert('{{ session('success') }}');</script>
    @endif

    @if (session('error'))
        <script>alert('{{ session('error') }}');</script>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Your Posts List</h4>
        <a href="{{ route('posts.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Create Post
        </a>
    </div>

    <form method="POST" action="{{ route('posts.deleteAll') }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Bạn xác nhận xoá tất cả bài viết?')" class="btn btn-link text-danger p-0 mb-3">
            Delete All
        </button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td style="width: 180px;">
                            <img src="{{ $post->thumbnail }}" alt="Thumbnail" class="img-fluid rounded" style="width: 140px; height: 100px; object-fit: cover;">
                        </td>
                        <td>{{ Str::limit($post->title, 30) }}</td>
                        <td>{{ Str::limit(strip_tags($post->description), 50) }}</td>
                        <td><span class="small">{{ $post->created_at->format('d/m/Y H:i') }}</span></td>
                        <td>
                            @if ($post->status == 0)
                                <span class="badge bg-success">Chờ duyệt</span>
                            @else
                                <span class="badge bg-primary">Đã sửa</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Xem --}}
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary btn-sm" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                        
                                {{-- Sửa --}}
                                <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-outline-warning btn-sm" title="Sửa">
                                    <i class="fas fa-pen"></i>
                                </a>
                        
                                {{-- Xoá --}}
                                <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá bài viết này?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Xoá">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if ($posts->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Không có bài viết nào.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endsection
