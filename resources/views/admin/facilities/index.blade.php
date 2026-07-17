@extends('admin.layouts.app')

@section('title', 'Academic Facilities')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Academic Facilities')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Learning Experience</span>
                <h2>Featured Facilities</h2>
                <p>Create, edit, order, and hide the facility cards shown in the homepage labs carousel.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.facilities.create') }}">Add Facility</a>
        </div>

        <div class="facility-admin-list">
            @forelse($facilities as $facility)
                <article class="campus-event-accent campus-event-accent--{{ $facility->accent ?: 'sky' }}">
                    <img src="{{ $facility->imageUrl() }}" alt="{{ $facility->image_alt ?: $facility->title }}">
                    <div>
                        <span class="status-pill {{ $facility->is_active ? 'active' : '' }}">{{ $facility->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $facility->title }}</h3>
                        <p>{{ $facility->description ?: 'No facility description added.' }}</p>
                        <small>{{ $facility->category ?: 'No category' }} &middot; Order {{ $facility->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.facilities.edit', $facility) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}" onsubmit="return confirm('Delete this academic facility? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No facilities</span>
                    <h3>No academic facilities are available yet.</h3>
                    <p>Add the first facility so it can appear in the homepage Learning Experience section.</p>
                    <a href="{{ route('admin.facilities.create') }}">Add Facility</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
