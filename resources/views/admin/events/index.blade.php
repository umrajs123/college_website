@extends('admin.layouts.app')

@section('title', 'Campus Events')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Campus Events')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Campus Calendar</span>
                <h2>Upcoming Events</h2>
                <p>Create, edit, order, and hide the events shown on the public homepage.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.events.create') }}">Add Event</a>
        </div>

        <div class="event-admin-list">
            @forelse($events as $event)
                <article>
                    <time>
                        <strong>{{ $event->starts_at->format('d') }}</strong>
                        <span>{{ $event->starts_at->format('M') }}</span>
                    </time>
                    <div>
                        <span class="status-pill {{ $event->is_active ? 'active' : '' }}">{{ $event->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $event->title }}</h3>
                        <p>{{ $event->description ?: 'No description added.' }}</p>
                        <small>{{ $event->category }} · {{ $event->venue ?: 'Venue pending' }} · {{ $event->starts_at->format('h:i A') }} · Order {{ $event->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this campus event? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No campus events</span>
                    <h3>No events are available yet.</h3>
                    <p>Add the first event so it can appear in the homepage Campus Calendar section.</p>
                    <a href="{{ route('admin.events.create') }}">Add Event</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
