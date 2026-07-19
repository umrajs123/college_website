<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'posts' => NewsPost::active()
                ->orderByDesc('published_at')
                ->orderBy('sort_order')
                ->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $post = NewsPost::active()->where('slug', $slug)->firstOrFail();

        return view('news.show', [
            'post' => $post,
            'latestPosts' => NewsPost::active()
                ->whereKeyNot($post->id)
                ->orderByDesc('published_at')
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ]);
    }
}
