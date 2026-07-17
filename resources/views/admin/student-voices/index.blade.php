@extends('admin.layouts.app')

@section('title', 'Student Voices')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Student Voices')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Testimonials</span>
                <h2>Homepage Student Slider</h2>
                <p>Create, edit, order, and hide the student stories shown in the homepage slider.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.student-voices.create') }}">Add Student Voice</a>
        </div>

        <div class="student-voice-admin-list">
            @forelse($voices as $voice)
                <article class="campus-event-accent campus-event-accent--{{ $voice->accent ?: 'sky' }}">
                    <img src="{{ $voice->imageUrl() }}" alt="{{ $voice->image_alt ?: $voice->name }}">
                    <div>
                        <span class="status-pill {{ $voice->is_active ? 'active' : '' }}">{{ $voice->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $voice->name }}</h3>
                        <p>{{ $voice->quote }}</p>
                        <small>{{ $voice->program ?: 'No program label' }} &middot; Order {{ $voice->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.student-voices.edit', $voice) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.student-voices.destroy', $voice) }}" onsubmit="return confirm('Delete this student voice? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No voices</span>
                    <h3>No student voices are available yet.</h3>
                    <p>Add the first testimonial so the homepage student slider can appear.</p>
                    <a href="{{ route('admin.student-voices.create') }}">Add Student Voice</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
