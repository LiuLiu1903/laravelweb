@extends('layouts.admin')


@section('css')
    <!-- QuillJS Full Feature -->
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="my-3">
        <a href="/admin/posts" class="ms-1 btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
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
        <h3 class="fw-bold mt-3">Chỉnh sửa bài viết - {{ $post->title }}</h3>
        <div class="form-edit">
            <form method="POST" action="{{ route('admin.posts.update', ['slug' => $post->slug]) }}"
                onsubmit="return confirm('Bạn xác nhận muốn chỉnh sửa dữ liệu này?')" id="createPost" class="mt-4"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="slug" value="{{ $post->slug }}">

                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Title</label>
                    <input type="text" class="form-control form-control-lg" id="title" name="title"
                        placeholder="Enter a compelling title..." value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="8"
                        placeholder="Write your description...">{{ old('description', $post->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="2" {{ $post->status == 2 ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label fw-semibold">Thumbnail</label>
                    <input type="file" class="form-control form-control-lg" id="thumbnail"
                        value="{{ old('thumbnail') }}" name="thumbnail">

                    <img class="my-2 rounded" style="width: 200px" src="{{ asset($post->thumbnail) }}" alt="">

                </div>

                <div class="mb-3">
                    <label for="publish_date" class="form-label fw-semibold">Publish Date</label>
                    <div class="input-group">
                        <input type="datetime-local" class="form-control" id="publish_date" name="publish_date"
                            value="{{ $post->publish_date }}">
                        <label class="input-group-text"><i class="fas fa-calendar-alt"></i></label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Content</label>
                    <div id="editor" style="height: 800px"></div>
                    <input type="hidden" name="content" id="hiddenContent">
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="my-2 gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <!-- QuillJS Core -->
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

    <!-- QuillJS Extensions -->
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-table@1.2.9/dist/quill-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-mention@2.1.0/dist/quill.mention.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }],
                    [{
                        font: []
                    }],
                    [{
                        size: ['small', false, 'large', 'huge']
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        script: 'sub'
                    }, {
                        script: 'super'
                    }],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    [{
                        indent: '-1'
                    }, {
                        indent: '+1'
                    }],
                    [{
                        align: []
                    }],
                    [{
                        direction: 'rtl'
                    }],
                    ['link', 'image', 'video', 'blockquote', 'code-block', 'formula'],
                    ['clean']
                ],
                clipboard: {
                    matchVisual: false
                },
                imageResize: {},
                mention: {
                    allowedChars: /^[A-Za-z\s]*$/,
                    mentionDenotationChars: ["@"],
                    source: function(searchTerm, renderList) {
                        const values = [{
                            id: 1,
                            value: 'Admin'
                        }, {
                            id: 2,
                            value: 'User'
                        }];
                        renderList(values.filter(v => v.value.toLowerCase().includes(searchTerm)));
                    }
                }
            }
        });

        quill.root.innerHTML = `{!! addslashes($post->content) !!}`;

        document.getElementById('createPost').onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        }
    </script>
@endsection
