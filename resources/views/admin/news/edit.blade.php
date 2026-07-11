@extends('admin.layouts.app')

@php($isCreate = $isCreate ?? false)

@section('title', $isCreate ? 'Add News Post' : 'Edit News Post')
@section('eyebrow', 'Homepage Content')
@section('page_title', $isCreate ? 'Add News Post' : 'Edit News Post')

@section('content')
    <form class="admin-form-shell" method="POST" enctype="multipart/form-data" action="{{ $isCreate ? route('admin.news.store') : route('admin.news.update', $post) }}">
        @csrf
        @unless($isCreate)
            @method('PUT')
        @endunless

        <section class="admin-form-card">
            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">News Details</span>
                    <h2>{{ $isCreate ? 'New Announcement' : 'Announcement Content' }}</h2>
                    <p>{{ $isCreate ? 'Add a public update with image, date, category, and story text.' : 'Changes update the public news card and detail page after saving.' }}</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Title
                    <input name="title" value="{{ old('title', $post->title) }}" placeholder="Admissions counseling desk opened for fall intake" required>
                    @error('title') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Slug
                    <input name="slug" value="{{ old('slug', $post->slug) }}" placeholder="admissions-counseling-desk-opened">
                    @error('slug') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Published Date
                    <input type="date" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}">
                    @error('published_at') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Category
                    <input name="category" value="{{ old('category', $post->category) }}" placeholder="Admissions" required>
                    @error('category') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Sort Order
                    <input type="number" name="sort_order" value="{{ old('sort_order', $post->sort_order) }}" min="0" max="999" required>
                    @error('sort_order') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Accent
                    <select name="accent" required>
                        @foreach(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'] as $accent)
                            <option value="{{ $accent }}" @selected(old('accent', $post->accent) === $accent)>{{ ucfirst($accent) }}</option>
                        @endforeach
                    </select>
                    @error('accent') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Image URL
                    <input name="image_path" value="{{ old('image_path', $post->image_path) }}" placeholder="https://images.unsplash.com/...">
                    @error('image_path') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Upload Image
                    <input type="file" name="image" accept="image/*">
                    @error('image') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Image Alt Text
                    <input name="image_alt" value="{{ old('image_alt', $post->image_alt) }}" placeholder="Students attending a pharmacy workshop">
                    @error('image_alt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Short Excerpt
                    <textarea name="excerpt" rows="3" placeholder="A compact summary for homepage cards.">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="span-2">
                    Full Story
                    <textarea name="body" rows="8" placeholder="Write the full announcement details here.">{{ old('body', $post->body) }}</textarea>
                    @error('body') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-check span-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $post->is_active))>
                    <span>Show this news post on the website</span>
                </label>
            </div>
        </section>

        <aside class="admin-preview-card news-preview-card">
            <span class="admin-kicker">{{ $isCreate ? 'New Post' : 'Current Post' }}</span>
            <img src="{{ $post->imageUrl() }}" alt="{{ $post->image_alt ?: $post->title ?: 'News preview' }}">
            <small>{{ $post->category ?: 'News' }} &middot; {{ optional($post->published_at)->format('M d, Y') ?: now()->format('M d, Y') }}</small>
            <h3>{{ $post->title ?: 'New SCPS announcement' }}</h3>
            <p>{{ $post->excerpt ?: 'Add a short excerpt so the homepage card feels clear and polished.' }}</p>
            <div class="admin-form-actions">
                <a href="{{ route('admin.news.index') }}">Cancel</a>
                <button type="submit">{{ $isCreate ? 'Create News' : 'Save Changes' }}</button>
            </div>
        </aside>
    </form>
@endsection
