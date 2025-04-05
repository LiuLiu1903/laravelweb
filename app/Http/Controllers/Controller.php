<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;

abstract class Controller
{
    protected function checkUpdatePermission($post)
    {
        if (!Auth::user()->can('update', $post)) {
            abort(403);
        }
    }
}
