<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()->latestPosts()->paginate(9);

        return view('blog.index', compact('posts'));
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
