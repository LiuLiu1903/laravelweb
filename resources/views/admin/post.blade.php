@extends('layouts.admin')
@section('subtitle', 'Quản lý bài viết')

@section('content')
    <h3 class="my-2">Quản lý bài viết</h3>

    <div class="search mb-3">
        <form action="{{route('admin.posts.search')}}" method="GET">
            @csrf
            <div class="d-flex">
                <div class="col-2">
                    <select name="type_search" id="type-search" class="form-control">
                        <option value="tieuDe">Tiêu đề</option>
                        <option value="email">Email</option>
                    </select>
                </div>

                <div class="col-6">
                    <input type="text" class="form-control" value="{{ request('search') }}" name="search" placeholder="Nhập từ khóa tìm kiếm">
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <script>
                alert('{{ session('success') }}');
            </script>
        </div>
    @endif

    <div class="">
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Người đăng</th>
                    <th>Ngày đăng</th>
                    <th>Trạng thái</th>
                    <th>Công cụ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td style="width: 200px">{{ $item->title }}</td>
                        <td style="width: 400px">{{ $item->description }}</td>
                        <td>{{ $item->user->email }}</td>
                        <td>{{ $item->publish_date }}</td>
                        <td>
                            <select class="form-control form-control-sm" onchange="updateStatus({{ $item->slug }}, this.value)">
                                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Mới</option>
                                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Đã duyệt</option>
                                <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.posts.edit', $item->slug) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Sửa
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection

@push('scripts')
<script>
    function updateStatus(slug, status) {
        fetch(`/admin/posts/${slug}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('Cập nhật trạng thái thành công');
            else alert('Thất bại');
        });
    }
</script>
@endpush
