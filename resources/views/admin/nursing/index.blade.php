@extends('admin.layouts.app')

@section('title', 'Nursing Page')
@section('eyebrow', 'Public Website Content')
@section('page_title', 'Nursing Page')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Nursing College</span>
                <h2>Page Content</h2>
                <p>Manage the Nursing page hero, college information, and feature cards. Change display order or hide content without deleting it.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.nursing.create') }}">Add Content</a>
        </div>

        <div class="program-admin-list">
            @forelse($sections as $section)
                <article class="campus-event-accent campus-event-accent--teal">
                    <span class="program-admin-icon">{{ $section->icon_label ?: 'NC' }}</span>
                    <div>
                        <span class="status-pill {{ $section->is_active ? 'active' : '' }}">{{ $section->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $section->title }}</h3>
                        <p>{{ $section->body }}</p>
                        <small>{{ ucfirst($section->section_type) }} &middot; Order {{ $section->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.nursing.edit', $section) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.nursing.destroy', $section) }}" onsubmit="return confirm('Delete this Nursing page content? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No Nursing page content</span>
                    <h3>Start building your Nursing page.</h3>
                    <p>Add a hero section, college information, and feature cards for the public website.</p>
                    <a href="{{ route('admin.nursing.create') }}">Add Content</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
