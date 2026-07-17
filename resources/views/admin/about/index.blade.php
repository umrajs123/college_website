@extends('admin.layouts.app')

@section('title', 'About Section')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'About Section')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">College Story</span>
                <h2>Homepage About Blocks</h2>
                <p>Create, edit, order, and hide the content used in the homepage About SCPS section.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.about.create') }}">Add About Block</a>
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
                    <p>Add the first about block so the homepage About SCPS section can appear.</p>
                    <a href="{{ route('admin.about.create') }}">Add About Block</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
