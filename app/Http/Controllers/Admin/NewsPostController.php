<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsPostController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', [
            'posts' => NewsPost::orderByDesc('published_at')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.edit', [
            'post' => new NewsPost([
                'category' => 'News',
                'accent' => 'sky',
                'published_at' => now(),
                'sort_order' => (NewsPost::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        NewsPost::create($this->validatedPost($request));

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News post created successfully.');
    }

    public function edit(NewsPost $post): View
    {
        return view('admin.news.edit', [
            'post' => $post,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, NewsPost $post): RedirectResponse
    {
        $post->update($this->validatedPost($request, $post));

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News post updated successfully.');
    }

    public function destroy(NewsPost $post): RedirectResponse
    {
        if ($post->image_path && ! str_starts_with($post->image_path, 'http')) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'News post deleted successfully.');
    }

    private function validatedPost(Request $request, ?NewsPost $post = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('title')),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:210', Rule::unique('news_posts', 'slug')->ignore($post)],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($post?->image_path && ! str_starts_with($post->image_path, 'http')) {
                Storage::disk('public')->delete($post->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        unset($validated['image']);

        return $validated;
    }
}
