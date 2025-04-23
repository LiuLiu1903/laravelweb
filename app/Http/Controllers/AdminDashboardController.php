<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Global search
        $searchResults = [];
        if ($request->has('global_search')) {
            $searchTerm = $request->global_search;
            
            $searchResults = [
                'users' => User::where('email', 'like', "%$searchTerm%")
                             ->orWhere('first_name','last_name', 'like', "%$searchTerm%")
                             ->limit(5)
                             ->get(),
                'posts' => Post::where('title', 'like', "%$searchTerm%")
                              ->with('user')
                              ->limit(5)
                              ->get()
            ];
        }

        // Thống kê
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'pending_posts' => Post::where('status', 'pending')->count()
        ];

        return view('admin.dashboard', compact('stats', 'searchResults'));
    }
}
