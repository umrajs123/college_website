@extends('admin.layouts.app')

@section('title', 'News & Announcements')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'News & Announcements')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">SCPS Updates</span>
                <h2>Published Stories</h2>
                <p>Create, edit, order, and hide the news cards shown on the public website.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.news.create') }}">Add News</a>
        </div>

        <div class="news-admin-list">
            @forelse($posts as $post)
                <article>
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->image_alt ?: $post->title }}">
                    <div>
                        <span class="status-pill {{ $post->is_active ? 'active' : '' }}">{{ $post->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->excerpt ?: 'No short excerpt added.' }}</p>
                        <small>{{ $post->category }} &middot; {{ optional($post->published_at)->format('M d, Y') ?: 'No date' }} &middot; Order {{ $post->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.news.edit', $post) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm('Delete this news post? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No news posts</span>
                    <h3>No announcements are available yet.</h3>
                    <p>Add the first news item so it can appear in the homepage Latest From SCPS section.</p>
                    <a href="{{ route('admin.news.create') }}">Add News</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
