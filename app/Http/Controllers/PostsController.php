<?php
namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $data            = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status']  = 0; // Default status

        $post = Post::create($data);

        if ($request->hasFile('thumbnail')) {
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnails');
        }

        return redirect()->route('posts.index')
            ->with('success', 'Tạo bài viết thành công!');
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
        // dd($data);

        // Update status only if changing from draft (0) to updated (1)
        $data['status'] = $post->status == 0 ? 1 : $post->status;

        $post->update($data);

        if ($request->hasFile('thumbnail')) {
            $post->clearMediaCollection('thumbnails');
            $post->addMediaFromRequest('thumbnail')
                ->toMediaCollection('thumbnails');
        }

        return redirect()->route('posts.index')
            ->with('success', 'Cập nhật bài viết thành công');
    }
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Xóa bài viết thành công!');
    }

    public function storeMedia(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        $path = $request->file('image')->store('public/tmp');
        $url  = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }

    public function dashboard()
    {
        $posts = Post::where('status', 2)->latest()->paginate(10);

        return view('dashboard', compact('posts'));
    }

}
