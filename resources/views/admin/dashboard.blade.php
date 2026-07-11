@extends('admin.layouts.app')

@section('title', 'SCPS Admin Dashboard')
@section('eyebrow', 'Website Overview')
@section('page_title', 'Dashboard')

@section('content')
    <section class="admin-hero-panel">
        <div>
            <span class="admin-kicker">Content Control</span>
            <h2>Start with the homepage leadership messages.</h2>
            <p>This first module proves the full admin flow: edit content here, save it, and the public website updates from the database.</p>
        </div>
        <a href="{{ route('admin.leadership.index') }}">Manage Leadership</a>
    </section>

    <section class="admin-stats">
        <article>
            <span>{{ $heroSlideCount }}</span>
            <strong>Hero slides</strong>
            <small>{{ $activeHeroSlideCount }} active slides appear in the homepage hero.</small>
        </article>
        <article>
            <span>{{ $facultyCount }}</span>
            <strong>Faculty profiles</strong>
            <small>{{ $activeFacultyCount }} active profiles are visible publicly.</small>
        </article>
        <article>
            <span>{{ $eventCount }}</span>
            <strong>Campus events</strong>
            <small>{{ $activeEventCount }} active events are visible on the homepage.</small>
        </article>
        <article>
            <span>{{ $newsCount }}</span>
            <strong>News posts</strong>
            <small>{{ $activeNewsCount }} active posts are visible publicly.</small>
        </article>
        <article>
            <span>{{ $leadershipCount }}</span>
            <strong>Leadership records</strong>
            <small>{{ $activeLeadershipCount }} active messages are visible publicly.</small>
        </article>
    </section>

    <section class="admin-module-grid">
        <article>
            <span>Ready</span>
            <h3>Leadership Messages</h3>
            <p>Director and Principal cards are editable from the admin panel.</p>
        </article>
        <article>
            <span>Ready</span>
            <h3>Hero Slides</h3>
            <p>Slides, buttons, headings, and images are editable from admin.</p>
        </article>
        <article>
            <span>Ready</span>
            <h3>Faculty Profiles</h3>
            <p>Faculty listing and detail pages now come from MySQL.</p>
        </article>
        <article>
            <span>Ready</span>
            <h3>Campus Events</h3>
            <p>Upcoming event cards are editable from admin.</p>
        </article>
        <article>
            <span>Ready</span>
            <h3>News & Announcements</h3>
            <p>Homepage news cards and public stories are editable from admin.</p>
        </article>
    </section>
@endsection
