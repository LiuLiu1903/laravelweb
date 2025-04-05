<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Post</h1>
        
        <form method="POST" action="{{ route('posts.update', $post->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            </div>
            
            <!-- Content with Summernote -->
            <div class="mb-3">
                <label for="summernote" class="form-label">Content</label>
                <textarea id="summernote" name="content" class="form-control">{{ old('content', $post->content) }}</textarea>
            </div>
            
            <!-- Thumbnail -->
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                
                @if($post->hasMedia('thumbnails'))
                    <div class="mt-2">
                        <img src="{{ $post->getFirstMediaUrl('thumbnails') }}" width="150" class="img-thumbnail">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_thumbnail" id="remove_thumbnail">
                            <label class="form-check-label" for="remove_thumbnail">
                                Remove current thumbnail
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImageToServer(files[0]);
                    }
                }
            });

            function uploadImageToServer(file) {
                let formData = new FormData();
                formData.append('image', file);
                
                $.ajax({
                    url: '{{ route("posts.storeMedia") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.url) {
                            $('#summernote').summernote('insertImage', response.url);
                        } else {
                            alert('Upload failed');
                        }
                    },
                    error: function() {
                        alert('Error uploading image');
                    }
                });
            }
        });
    </script>
</body>
</html>