<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Jobs\PostsJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{

    // Display the list of posts
    public function showPosts(Request $request)
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.post', compact('posts'));
    }

    public function showEditPost($slug = null)
    {
        if (! $slug) {
            return redirect()->route('admin.posts.index')->with('error', 'Có lỗi xảy ra. Không tìm thấy bài viết');
        }

        $post = Post::where('slug', $slug)->first();

        if ($post) {
            return view('admin.post-edit', compact('post'));
        } else {
            return redirect()->route('admin.posts.index')->with('error', 'Có lỗi xảy ra. Không tìm thấy bài viết');
        }

    }

    public function searchPost(Request $request)
    {
        $search      = $request->search ? "$request->search" : '';
        $type_search = $request->type_search ? "$request->type_search" : '';

        if ($request->type_search == 'tieuDe') {
            $query = Post::with('user')
                ->where('title', 'LIKE', "%$search%");

        }

        if ($request->type_search == 'email') {
            $query = Post::with('user')
                ->whereHas('user', fn($q) => $q->where('email', 'LIKE', "%$search%"));
        }

        $posts = $query->orderBy('id', 'ASC')
            ->paginate(15)
            ->appends(['search' => $search, 'type_search' => $type_search]);

        return view('admin.post', compact('posts', 'search', 'type_search'));
    }

    public function updateStatus(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->status = $request->status;
        $post->save();
    
        return response()->json(['success' => true]);
    }

    public function editPost(PostRequest $request)
    {
        $post       = Post::where('slug', $request->slug)->first();
        $user_Email = User::where('id', $post->user_id)->first()->email;
        if (! $post) {
            return back()->with('error', 'Có lỗi xảy ra.');
        }

        $post->title        = $request->title;
        $post->description  = $request->description;
        $post->content      = $request->content;
        $post->status       = $request->status;
        $post->publish_date = $request->publish_date;

        $post->save();

        if ($request->status == 1) {
            dispatch(new PostsJob($post));
        }

        if ($request->hasFile('thumbnail')) {
            $post->clearMediaCollection('thumbnails');

            $post->addMedia($request->file('thumbnail'))
                ->toMediaCollection('thumbnails', 'media-library');
        }

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công');
    }
}
