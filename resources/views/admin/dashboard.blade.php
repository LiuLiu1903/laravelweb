@extends('adminlte::page')

@section('title', 'Bảng điều khiển quản trị')

@section('content_header')
    <h1 class="m-0 text-dark">Bảng điều khiển</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Global Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('admin.dashboard') }}" method="GET">
                <div class="input-group">
                    <input type="text" 
                           name="global_search" 
                           class="form-control form-control-lg" 
                           placeholder="Tìm kiếm toàn hệ thống..."
                           value="{{ request('global_search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p>Người dùng</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_posts'] }}</h3>
                    <p>Bài viết</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['pending_posts'] }}</h3>
                    <p>Bài chờ duyệt</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.posts.index') }}?status=pending" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> --}}
    </div>

    <!-- Search Results -->
    @if(!empty($searchResults))
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kết quả tìm kiếm cho "{{ request('global_search') }}"</h3>
                </div>
                
                <div class="card-body">
                    @foreach($searchResults as $type => $items)
                        <div class="mb-4">
                            <h4>{{ ucfirst($type) }} ({{ count($items) }})</h4>
                            @if(count($items) > 0)
                                <div class="list-group">
                                    @foreach($items as $item)
                                        @if($type === 'users')
                                            <a href="{{ route('admin.users.index') }}?search={{ $item->email }}" 
                                               class="list-group-item list-group-item-action">
                                                <i class="fas fa-user mr-2"></i>
                                                {{ $item->name }} ({{ $item->email }})
                                            </a>
                                        @elseif($type === 'posts')
                                            <a href="{{ route('posts.show', $item->slug) }}" 
                                               class="list-group-item list-group-item-action"
                                               target="_blank">
                                                <i class="fas fa-file-alt mr-2"></i>
                                                {{ $item->title }} 
                                                <small class="text-muted">- {{ $item->user->email }}</small>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">Không tìm thấy kết quả</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop

@section('css')
<style>
    .small-box .icon {
        font-size: 70px;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
</style>
@stop