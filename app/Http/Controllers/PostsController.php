<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = 0; // Default status

        $post = Post::create($data);

        if ($request->hasFile('thumbnail')) {
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnails');
        }

        return redirect()->route('posts.index')->with('success', 'Tạo bài viết thành công!');
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        $data['status'] = $post->status == 0 ? 1 : $post->status;

        $post->update($data);

        if ($request->hasFile('thumbnail')) {
            $post->clearMediaCollection('thumbnails');
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnails');
        }

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Xóa bài viết thành công!');
    }

    public function deleteAll()
    {
        $user = Auth::user();

        if (!$user) {
            return view('error.pageerror');
        }

        $deleted = $user->posts()->delete();

        if ($deleted) {
            return redirect()->route('posts.index')->with('success', 'Xoá tất cả bài viết thành công');
        } else {
            return redirect()->route('posts.index')->with('error', 'Có lỗi xảy ra. Xoá thất bại');
        }
    }

    public function data()
    {
        $posts = auth()->user()->posts()->select('id', 'title', 'status', 'created_at');
        return datatables($posts)->make(true);
    }

    public function storeMedia(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('public/tmp');
        $url = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }

    public function dashboard()
    {
        $posts = Post::where('status', 2)->latest()->paginate(10);
        return view('dashboard', compact('posts'));
    }

    public function showTrash()
    {
        $userID = Auth::id();
        $trashedPost = Post::where('user_id', $userID)->onlyTrashed()->paginate(6);
        return view('posts.deleted', compact('trashedPost'));
    }

    public function restorePost(Request $request)
    {
        if (!$request->slug) {
            return view('error.pageerror');
        }

        $post = Post::withTrashed()->where('slug', $request->slug)->restore();

        if ($post) {
            return back()->with('success', 'Khôi phục bài viết thành công');
        } else {
            return back()->with('error', 'Có lỗi xảy ra. Khôi phục bài viết thất bại');
        }
    }
}
