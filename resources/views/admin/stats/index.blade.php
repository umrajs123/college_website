@extends('admin.layouts.app')

@section('title', 'Stats Counters')
@section('eyebrow', 'Homepage Content')
@section('page_title', 'Stats Counters')

@section('content')
    <section class="admin-table-card">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Numbers Section</span>
                <h2>Homepage Counters</h2>
                <p>Create, edit, order, and hide the animated numbers shown in the homepage stats section.</p>
            </div>
            <a class="admin-create-link" href="{{ route('admin.stats.create') }}">Add Statistic</a>
        </div>

        <div class="stats-admin-list">
            @forelse($stats as $stat)
                <article class="campus-event-accent campus-event-accent--{{ $stat->accent ?: 'sky' }}">
                    <span class="stats-admin-icon">{{ $stat->icon_label ?: '#' }}</span>
                    <div>
                        <span class="status-pill {{ $stat->is_active ? 'active' : '' }}">{{ $stat->is_active ? 'Active' : 'Hidden' }}</span>
                        <h3>{{ $stat->prefix }}{{ number_format($stat->value) }}{{ $stat->suffix }}</h3>
                        <p>{{ $stat->label }}</p>
                        <small>{{ $stat->description ?: 'No note added.' }} &middot; Order {{ $stat->sort_order }}</small>
                    </div>
                    <div class="admin-row-actions">
                        <a href="{{ route('admin.stats.edit', $stat) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" onsubmit="return confirm('Delete this statistic? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-empty-state">
                    <span>No stats</span>
                    <h3>No homepage counters are available yet.</h3>
                    <p>Add the first statistic so the animated counter section can appear on the homepage.</p>
                    <a href="{{ route('admin.stats.create') }}">Add Statistic</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
