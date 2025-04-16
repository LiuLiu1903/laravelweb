@extends('layouts.app')
 
 @section('title', 'Trashed Post')
 
 @section('content')
 
 @if (session('success'))
     <script>
         alert('{{ session('success') }}');
     </script>
 @endif
 
 @if (session('error'))
     <script>
         alert('{{ session('error') }}');
     </script>
 @endif
 
 <div class="container">
     <p class="fs-4 fw-bold">Trashed Post</p>
 </div>
 
 <div class="container mt-1">
     <div class="row" id="postList">
         @foreach ($trashedPost as $post)
 
             <div class="col-md-6 col-lg-4 mb-4">
                 <div class="card shadow-sm position-relative" style="height: 420px">
                     <img src="{{ $post->thumbnail }}"
                         class="card-img-top" alt="Thumbnails" style="height: 230px;width: 100%; object-fit: cover;">
                     <div class="card-body">
                         <h5 class="card-title">{{  Str::limit($post->title, 30) }}</h5>
                         <p class="text-muted" style="height: 40px">{{ Str::limit(strip_tags($post->description), 80) }}</p>
                         <div class="d-flex justify-content-between">
                             <a href="/training/posts/detail/{{ $post->slug }}"
                                 class="btn btn-sm btn-outline-primary"><i class="fa fa-eye" aria-hidden="true"></i>
                                 Read More</a>
                             <span class="text-muted small"><b><i class="fas fa-calendar-alt me-2"></i> </b>
                                 {{ $post->publish_date }}</span>
                         </div>
                         
                         <div class="mt-2 text-end">
                             <form action="{{route('training.posts.restore')}}" method="post">
                                 @csrf
                                 <input type="hidden" value="{{$post->slug}}" name="slug">
                                 <button class="btn btn-danger" type="submit"><i class="fa-solid fa-arrow-rotate-left"></i></button>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
             
         @endforeach
     </div>
 
     <div class="d-flex justify-content-center mt-3"> 
         {{ $trashedPost->links() }}
     </div>
 @endsection