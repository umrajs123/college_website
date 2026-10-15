<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SCPS Admin')</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        if (localStorage.getItem('scps-admin-theme') === 'dark') {
            document.documentElement.classList.add('admin-dark');
        }
        if (localStorage.getItem('scps-admin-sidebar') === 'collapsed') {
            document.documentElement.classList.add('admin-sidebar-collapsed');
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-shell">
    @php
        $adminSearchItems = [
            ['label' => 'Dashboard', 'hint' => 'Website overview and content health', 'url' => route('admin.dashboard'), 'code' => 'DB'],
            ['label' => 'Leadership Messages', 'hint' => 'Director and Principal messages', 'url' => route('admin.leadership.index'), 'code' => 'LM'],
            ['label' => 'Hero Slides', 'hint' => 'Homepage slider headings, buttons, and images', 'url' => route('admin.hero-slides.index'), 'code' => 'HS'],
            ['label' => 'Faculty', 'hint' => 'Faculty profiles and public directory', 'url' => route('admin.faculty.index'), 'code' => 'FC'],
            ['label' => 'Events', 'hint' => 'Campus calendar and event listings', 'url' => route('admin.events.index'), 'code' => 'EV'],
            ['label' => 'News', 'hint' => 'Announcements and story posts', 'url' => route('admin.news.index'), 'code' => 'NW'],
            ['label' => 'Programs', 'hint' => 'Academic areas and program pages', 'url' => route('admin.programs.index'), 'code' => 'PR'],
            ['label' => 'Nursing Page', 'hint' => 'Nursing College page content', 'url' => route('admin.nursing.index'), 'code' => 'NC'],
            ['label' => 'Stats', 'hint' => 'Homepage animated counters', 'url' => route('admin.stats.index'), 'code' => 'ST'],
            ['label' => 'Student Voices', 'hint' => 'Homepage testimonial slider', 'url' => route('admin.student-voices.index'), 'code' => 'SV'],
            ['label' => 'Facilities', 'hint' => 'Labs and academic facilities', 'url' => route('admin.facilities.index'), 'code' => 'LB'],
            ['label' => 'About', 'hint' => 'Homepage about section', 'url' => route('admin.about.index'), 'code' => 'AB'],
            ['label' => 'Campus Life', 'hint' => 'Student experience homepage block', 'url' => route('admin.campus-life.edit'), 'code' => 'CL'],
            ['label' => 'Site Settings', 'hint' => 'Logo, contact info, admissions link', 'url' => route('admin.settings.edit'), 'code' => 'SS'],
            ['label' => 'Security', 'hint' => 'Admin password and account access', 'url' => route('admin.security.edit'), 'code' => 'SC'],
        ];
    @endphp

    <aside class="admin-sidebar">
        <div class="admin-sidebar-head">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->site_name }} logo">
                <span>
                    <strong>{{ $siteSettings->site_name }}</strong>
                    <small>Website Admin</small>
                </span>
            </a>
            <button class="admin-sidebar-toggle" type="button" data-admin-sidebar-toggle aria-label="Collapse sidebar" aria-pressed="false">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m15 6-6 6 6 6"></path>
                </svg>
            </button>
        </div>

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
            <a class="{{ request()->routeIs('admin.nursing.*') ? 'active' : '' }}" href="{{ route('admin.nursing.index') }}">
                <span>08</span>
                Nursing Page
            </a>
            <a class="{{ request()->routeIs('admin.stats.*') ? 'active' : '' }}" href="{{ route('admin.stats.index') }}">
                <span>09</span>
                Stats
            </a>
            <a class="{{ request()->routeIs('admin.student-voices.*') ? 'active' : '' }}" href="{{ route('admin.student-voices.index') }}">
                <span>10</span>
                Student Voices
            </a>
            <a class="{{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}" href="{{ route('admin.facilities.index') }}">
                <span>11</span>
                Facilities
            </a>
            <a class="{{ request()->routeIs('admin.about.*') ? 'active' : '' }}" href="{{ route('admin.about.index') }}">
                <span>12</span>
                About
            </a>
            <a class="{{ request()->routeIs('admin.campus-life.*') ? 'active' : '' }}" href="{{ route('admin.campus-life.edit') }}">
                <span>13</span>
                Campus Life
            </a>
            <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                <span>14</span>
                Site Settings
            </a>
            <a class="{{ request()->routeIs('admin.security.*') ? 'active' : '' }}" href="{{ route('admin.security.edit') }}">
                <span>15</span>
                Security
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
                <div class="admin-quick-search" data-admin-search>
                    <label for="adminQuickSearch" class="sr-only">Search admin modules</label>
                    <span class="admin-quick-search__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
                    </span>
                    <input id="adminQuickSearch" type="search" placeholder="Find module..." autocomplete="off" data-admin-search-input>
                    <div class="admin-search-results" data-admin-search-results>
                        <div class="admin-search-results__head">
                            <span>Quick Search</span>
                            <small data-admin-search-count>{{ count($adminSearchItems) }} modules</small>
                        </div>
                        @foreach($adminSearchItems as $item)
                            <a href="{{ $item['url'] }}" data-admin-search-item data-search-label="{{ \Illuminate\Support\Str::lower($item['label']) }}" data-search-text="{{ \Illuminate\Support\Str::lower($item['label'].' '.$item['hint']) }}">
                                <span>{{ $item['code'] }}</span>
                                <div>
                                    <strong>{{ $item['label'] }}</strong>
                                    <small>{{ $item['hint'] }}</small>
                                </div>
                                <em>Open</em>
                            </a>
                        @endforeach
                        <p data-admin-search-empty>No matching module found.</p>
                    </div>
                </div>
                <button class="admin-theme-toggle" type="button" data-admin-theme-toggle aria-label="Toggle admin theme" aria-pressed="false">
                    <span class="admin-theme-toggle__sun" aria-hidden="true">☀</span>
                    <span class="admin-theme-toggle__track" aria-hidden="true"><span></span></span>
                    <span class="admin-theme-toggle__moon" aria-hidden="true">◐</span>
                    <strong data-admin-theme-label>Light</strong>
                </button>
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
    <script>
        (() => {
            const toggle = document.querySelector('[data-admin-theme-toggle]');
            const label = document.querySelector('[data-admin-theme-label]');
            const sidebarToggle = document.querySelector('[data-admin-sidebar-toggle]');
            const searchWrap = document.querySelector('[data-admin-search]');
            const searchInput = document.querySelector('[data-admin-search-input]');
            const searchItems = [...document.querySelectorAll('[data-admin-search-item]')];
            const searchEmpty = document.querySelector('[data-admin-search-empty]');
            const searchCount = document.querySelector('[data-admin-search-count]');
            const root = document.documentElement;

            const syncTheme = () => {
                const isDark = root.classList.contains('admin-dark');
                toggle?.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                if (label) label.textContent = isDark ? 'Dark' : 'Light';
            };

            const syncSidebar = () => {
                sidebarToggle?.setAttribute('aria-pressed', root.classList.contains('admin-sidebar-collapsed') ? 'true' : 'false');
            };

            const filterSearch = () => {
                const query = searchInput?.value.trim().toLowerCase() || '';
                const queryTokens = query.split(/\s+/).filter(Boolean);
                const exactMatches = query === ''
                    ? []
                    : searchItems.filter((item) => item.dataset.searchLabel === query || item.dataset.searchLabel.replace(/\s+/g, '') === query.replace(/\s+/g, ''));
                let visible = 0;

                searchItems.forEach((item) => {
                    const label = item.dataset.searchLabel || '';
                    const text = item.dataset.searchText || '';
                    const words = label.split(/\s+/);
                    const match = exactMatches.length
                        ? exactMatches.includes(item)
                        : query === ''
                            || label.startsWith(query)
                            || label.includes(query)
                            || words.some((word) => word.startsWith(query))
                            || queryTokens.every((token) => text.includes(token));

                    item.hidden = !match;
                    if (match) visible += 1;
                });

                if (searchEmpty) searchEmpty.hidden = visible > 0;
                if (searchCount) searchCount.textContent = `${visible} ${visible === 1 ? 'match' : 'matches'}`;
                searchWrap?.classList.toggle('is-open', document.activeElement === searchInput || query !== '');
            };

            syncTheme();
            syncSidebar();

            toggle?.addEventListener('click', () => {
                root.classList.toggle('admin-dark');
                localStorage.setItem('scps-admin-theme', root.classList.contains('admin-dark') ? 'dark' : 'light');
                syncTheme();
            });

            sidebarToggle?.addEventListener('click', () => {
                root.classList.toggle('admin-sidebar-collapsed');
                localStorage.setItem('scps-admin-sidebar', root.classList.contains('admin-sidebar-collapsed') ? 'collapsed' : 'expanded');
                syncSidebar();
            });

            searchInput?.addEventListener('input', filterSearch);
            searchInput?.addEventListener('focus', filterSearch);

            document.addEventListener('click', (event) => {
                if (searchWrap && !searchWrap.contains(event.target)) {
                    searchWrap.classList.remove('is-open');
                }
            });
        })();
    </script>
</body>
</html>
