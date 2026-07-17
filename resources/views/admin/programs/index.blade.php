@extends('admin.layouts.app')

@section('title', 'Academic Programs')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Academic Programs')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Academic Areas</span>
                <h2>Program Cards</h2>
                <p>Create, edit, order, and hide the program cards shown in the homepage Academic Areas section.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.programs.create') }}">Add Program</a>
        </div>

        <div class="program-admin-list">
            @forelse($programs as $program)
                <article class="campus-event-accent campus-event-accent--{{ $program->accent ?: 'sky' }}">
                    <span class="program-admin-icon">{{ $program->icon_label }}</span>
                    <div>
                        <span class="status-pill {{ $program->is_active ? 'active' : '' }}">{{ $program->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $program->title }}</h3>
                        <p>{{ $program->description ?: 'No short program description added.' }}</p>
                        <small>Slug {{ $program->slug }} &middot; Order {{ $program->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.programs.edit', $program) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Delete this academic program? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No programs</span>
                    <h3>No academic programs are available yet.</h3>
                    <p>Add the first program so it can appear in the homepage Academic Areas section.</p>
                    <a href="{{ route('admin.programs.create') }}">Add Program</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
