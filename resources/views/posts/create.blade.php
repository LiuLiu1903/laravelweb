@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo bài viết mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="{{ old('title') }}" required maxlength="100">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả ngắn</label>
            <textarea name="description" id="description" class="form-control" 
                      rows="3" maxlength="200">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
            <textarea name="content" id="content" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện</label>
            <input type="file" name="thumbnail" id="thumbnail" 
                   class="form-control" accept="image/*">
            @if(isset($post) && $post->getFirstMediaUrl('thumbnails'))
                <div class="mt-2">
                    <img src="{{ $post->getFirstMediaUrl('thumbnails') }}" alt="Thumbnail" style="max-height: 150px;">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="publish_date" class="form-label">Ngày xuất bản</label>
            <input type="datetime-local" name="publish_date" id="publish_date" 
                   class="form-control" value="{{ old('publish_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">Tạo bài viết</button>
    </form>
</div>
@endsection

@section('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
            ]
        });
    });
</script>
@endsection