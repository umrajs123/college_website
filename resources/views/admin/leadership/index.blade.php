@extends('admin.layouts.app')

@section('title', 'Leadership Messages')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Leadership Messages')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Homepage Section</span>
                <h2>Director and Principal Messages</h2>
                <p>Edit the cards that appear below the hero section on the public website.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.leadership.create') }}">Add Leadership Message</a>
        </div>

        <div class="leadership-admin-list">
            @forelse($messages as $message)
                <article>
                    <img src="{{ $message->imageUrl() }}" alt="{{ $message->role }} portrait">
                    <div>
                        <span class="status-pill {{ $message->is_active ? 'active' : '' }}">{{ $message->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $message->title }}</h3>
                        <p>{{ $message->message }}</p>
                        <small>{{ $message->role }} · {{ $message->subtitle }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.leadership.edit', $message) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.leadership.destroy', $message) }}" onsubmit="return confirm('Delete this leadership message? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No leadership messages</span>
                    <h3>No leadership messages are available yet.</h3>
                    <p>Add Director and Principal messages from the database/admin workflow so they can appear below the homepage hero.</p>
                    <a href="{{ route('admin.leadership.create') }}">Add Leadership Message</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
