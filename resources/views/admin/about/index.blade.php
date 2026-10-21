@extends('admin.layouts.app')

@section('title', 'About Section')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'About Section')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">College Story</span>
                <h2>About Us Content</h2>
                <p>Manage the image, full story, highlights, and call to action shown on both the homepage and About Us page.</p>
            </div>
            @if($sections->isNotEmpty())
                <div class="about-admin-actions">
                    <a class="about-admin-action about-admin-action--preview" href="{{ route('about.show') }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.3-6 9.5-6 9.5 6 9.5 6-3.3 6-9.5 6-9.5-6-9.5-6Z"></path><circle cx="12" cy="12" r="2.7"></circle></svg>
                        <span>Preview About Us</span>
                    </a>
                    <a class="about-admin-action about-admin-action--edit" href="{{ route('admin.about.edit', $sections->first()) }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 5 4 4M4 20l4.2-.9L19 8.3a2.1 2.1 0 0 0-3-3L5.2 16.1 4 20Z"></path></svg>
                        <span>Edit About Us</span>
                    </a>
                </div>
            @endif
        </div>

        <div class="about-admin-list">
            @forelse($sections as $section)
                <article class="campus-event-accent campus-event-accent--{{ $section->accent ?: 'sky' }}">
                    <img src="{{ $section->imageUrl() }}" alt="{{ $section->image_alt ?: $section->heading }}">
                    <div>
                        <span class="status-pill {{ $section->is_active ? 'active' : '' }}">{{ $section->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $section->heading }}</h3>
                        <p>{{ $section->body ?: 'No about text added.' }}</p>
                        <small>{{ $section->eyebrow }} &middot; Order {{ $section->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.about.edit', $section) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.about.destroy', $section) }}" onsubmit="return confirm('Delete this about block? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No about content</span>
                    <h3>No About section content is available yet.</h3>
                    <p>There is no About Us content to edit yet. Contact your site administrator to restore or configure the About section.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
