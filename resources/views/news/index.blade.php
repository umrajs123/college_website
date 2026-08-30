<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Latest news and announcements from {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}.">
    <title>News - {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}</title>
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

    <main class="newsroom-page">
        <section class="newsroom-hero">
            <div class="container">
                <div class="newsroom-hero__grid">
                    <div>
                        <span class="newsroom-kicker">SCPS Newsroom</span>
                        <h1 class="newsroom-title">Latest News and Announcements</h1>
                        <p class="newsroom-intro">Follow admissions updates, academic notices, faculty activity, seminars, and campus highlights from Swat College of Pharmaceutical Sciences.</p>
                    </div>
                    <div class="newsroom-summary">
                        <strong>{{ $posts->total() }}</strong>
                        <span>{{ $posts->total() === 1 ? 'published update' : 'published updates' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="newsroom-section">
            <div class="container">
                <div class="newsroom-board newsroom-board--flush">
                    <div class="newsroom-board__head">
                        <span>Campus Updates</span>
                        <h2>Recent From Campus</h2>
                    </div>
                    <div class="newsroom-card-grid">
                        @forelse($posts as $post)
                            <article class="campus-event-accent campus-event-accent--{{ $post->accent ?: 'sky' }} newsroom-card">
                                <a class="newsroom-card__image" href="{{ route('news.show', $post->slug) }}">
                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->image_alt ?: $post->title }}">
                                </a>
                                <div class="newsroom-card__body">
                                    <div class="newsroom-card__meta">
                                        <span class="campus-event-category">{{ $post->category }}</span>
                                        <small>{{ optional($post->published_at)->format('M d, Y') ?: 'No date' }}</small>
                                    </div>
                                    <h3>{{ $post->title }}</h3>
                                    <p>{{ $post->excerpt ?: str($post->body)->limit(120) }}</p>
                                    <a class="campus-event-link" href="{{ route('news.show', $post->slug) }}">Read More</a>
                                </div>
                            </article>
                        @empty
                            <div class="newsroom-empty">
                                <span>Newsroom</span>
                                <h2>No news posts are available right now.</h2>
                                <p>Announcements will appear here after they are published from the admin panel.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($posts->hasPages())
                    <div class="event-pagination newsroom-pagination">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
