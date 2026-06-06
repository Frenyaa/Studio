<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->latestPosts()
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->paginate(9)
            ->withQueryString();

        $categories = Post::CATEGORIES;

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        $related = Post::published()
            ->latestPosts()
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
