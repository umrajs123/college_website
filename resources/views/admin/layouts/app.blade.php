<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SCPS Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/scps-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/scps-logo.png') }}" alt="SCPS logo">
            <span>
                <strong>SCPS</strong>
                <small>Website Admin</small>
            </span>
        </a>

        <nav class="admin-nav" aria-label="Admin navigation">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span>01</span>
                Dashboard
            </a>
            <a class="{{ request()->routeIs('admin.leadership.*') ? 'active' : '' }}" href="{{ route('admin.leadership.index') }}">
                <span>02</span>
                Leadership Messages
            </a>
            <a class="{{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}" href="{{ route('admin.hero-slides.index') }}">
                <span>03</span>
                Hero Slides
            </a>
            <a class="{{ request()->routeIs('admin.faculty.*') ? 'active' : '' }}" href="{{ route('admin.faculty.index') }}">
                <span>04</span>
                Faculty
            </a>
            <a class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                <span>05</span>
                Events
            </a>
            <a class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                <span>06</span>
                News
            </a>
            <a class="{{ request()->routeIs('admin.programs.*') ? 'active' : '' }}" href="{{ route('admin.programs.index') }}">
                <span>07</span>
                Programs
            </a>
            <a class="{{ request()->routeIs('admin.stats.*') ? 'active' : '' }}" href="{{ route('admin.stats.index') }}">
                <span>08</span>
                Stats
            </a>
            <a class="{{ request()->routeIs('admin.student-voices.*') ? 'active' : '' }}" href="{{ route('admin.student-voices.index') }}">
                <span>09</span>
                Student Voices
            </a>
            <a class="{{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}" href="{{ route('admin.facilities.index') }}">
                <span>10</span>
                Facilities
            </a>
            <a class="{{ request()->routeIs('admin.about.*') ? 'active' : '' }}" href="{{ route('admin.about.index') }}">
                <span>11</span>
                About
            </a>
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <small>@yield('eyebrow', 'SCPS Control Room')</small>
                <h1>@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="admin-topbar__actions">
                <a href="{{ url('/') }}" target="_blank">View Website</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </header>

        @if(session('status'))
            <div class="admin-alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
