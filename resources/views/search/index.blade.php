<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Search {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}.">
    <title>Search - {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-white text-slate-950">
    @include('partials.site-header')

    <main class="search-page">
        <section class="search-page-hero">
            <div class="container">
                <span>Search SCPS</span>
                <h1>Find programs, faculty, news, events, and campus facilities.</h1>
                <form method="GET" action="{{ route('search.index') }}">
                    <input name="q" type="search" value="{{ $query }}" placeholder="Search SCPS..." required>
                    <button type="submit">Search</button>
                </form>
            </div>
        </section>

        <section class="search-page-results">
            <div class="container">
                @if($query === '')
                    <div class="search-empty">
                        <span>Start Searching</span>
                        <h2>Type a keyword to search the website.</h2>
                        <p>You can search programs, faculty, news, events, and facilities.</p>
                    </div>
                @elseif($results->isEmpty())
                    <div class="search-empty">
                        <span>No Results</span>
                        <h2>No results found for "{{ $query }}".</h2>
                        <p>Try another keyword or search for program names, faculty names, admissions, events, or labs.</p>
                    </div>
                @else
                    <div class="search-results-head">
                        <span>{{ $results->count() }} result{{ $results->count() === 1 ? '' : 's' }}</span>
                        <h2>Results for "{{ $query }}"</h2>
                    </div>

                    <div class="search-results-grid">
                        @foreach($results as $result)
                            <a href="{{ $result['url'] }}" class="search-result-card">
                                <span>{{ $result['type'] }}</span>
                                <h3>{{ $result['title'] }}</h3>
                                @if(! empty($result['excerpt']))
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($result['excerpt']), 170) }}</p>
                                @endif
                                <strong>Open result</strong>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
