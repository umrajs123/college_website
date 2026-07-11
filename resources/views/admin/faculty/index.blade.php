@extends('admin.layouts.app')

@section('title', 'Faculty Profiles')
@section('eyebrow', 'People & Profiles')
@section('page_title', 'Faculty Profiles')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Faculty Directory</span>
                <h2>Academic Mentors</h2>
                <p>Create, edit, order, and hide faculty profiles shown on the public website.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.faculty.create') }}">Add Faculty</a>
        </div>

        <div class="faculty-admin-list">
            @forelse($faculty as $member)
                <article>
                    <img src="{{ $member->imageUrl() }}" alt="{{ $member->name }}">
                    <div>
                        <span class="status-pill {{ $member->is_active ? 'active' : '' }}">{{ $member->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $member->name }}</h3>
                        <p>{{ $member->summary }}</p>
                        <small>{{ $member->department }} · {{ $member->designation }} · Order {{ $member->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.faculty.edit', $member) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.faculty.destroy', $member) }}" onsubmit="return confirm('Delete this faculty member? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No faculty profiles</span>
                    <h3>No faculty members are available yet.</h3>
                    <p>Add the first faculty profile from here, then publish it so it appears on the public faculty section.</p>
                    <a href="{{ route('admin.faculty.create') }}">Add Faculty</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
