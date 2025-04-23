@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content_header')
    <h1 class="m-0 text-dark">Quản lý Người dùng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Tìm theo email hoặc tên..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select class="form-control user-status" 
                                data-user-id="{{ $user->id }}"
                                style="width: 150px;">
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Vô hiệu hóa</option>
                            <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.delete', $user->id) }}" 
                              method="POST" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Xử lý thay đổi trạng thái
    $('.user-status').change(function() {
        const userId = $(this).data('user-id');
        const newStatus = $(this).val();
        
        $.ajax({
            url: '/admin/users/' + userId + '/status',
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                toastr.success('Cập nhật trạng thái thành công');
            },
            error: function(xhr) {
                toastr.error('Có lỗi xảy ra khi cập nhật');
            }
        });
    });

    // Khởi tạo DataTable (nếu cần)
    $('.table').DataTable({
        "paging": false,
        "searching": false,
        "info": false
    });
});
</script>
@stop