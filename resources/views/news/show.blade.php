<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $post->excerpt ?: $post->title }}">
    <title>{{ $post->title }} - Swat College of Pharmaceutical Sciences</title>
    <link rel="icon" type="image/png" href="{{ asset('images/scps-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/scps-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-white text-slate-950">
    @include('partials.site-header')

    @php
        $bodyText = trim($post->body ?: 'Full details for this announcement will be added soon.');
        $paragraphs = collect(preg_split("/\r\n|\n|\r/", $bodyText))->map(fn ($paragraph) => trim($paragraph))->filter()->values();
        $readMinutes = max(1, (int) ceil(str_word_count(strip_tags($bodyText)) / 220));
    @endphp

    <main class="news-story campus-event-accent campus-event-accent--{{ $post->accent ?: 'sky' }}">
        <section class="news-story-single-wrap">
            <div class="container">
                <article class="news-story-single">
                    <nav class="news-story-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a>
                        <span>News</span>
                        <a href="{{ route('news.index') }}">Announcements</a>
                    </nav>

                    <header class="news-story-single__header">
                        <div class="news-story-meta">
                            <span>{{ $post->category }}</span>
                            <span>{{ optional($post->published_at)->format('F d, Y') ?: 'SCPS Update' }}</span>
                            <span>{{ $readMinutes }} min read</span>
                        </div>

                        <h1 class="news-story-title">{{ $post->title }}</h1>

                        @if($post->excerpt)
                            <p class="news-story-excerpt">{{ $post->excerpt }}</p>
                        @endif
                    </header>

                    <figure class="news-story-single__media">
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->image_alt ?: $post->title }}">
                    </figure>

                    <div class="news-story-info-strip">
                        <div>
                            <span>Category</span>
                            <strong>{{ $post->category }}</strong>
                        </div>
                        <div>
                            <span>Published</span>
                            <strong>{{ optional($post->published_at)->format('M d, Y') ?: 'Not dated' }}</strong>
                        </div>
                        <div>
                            <span>Reading Time</span>
                            <strong>{{ $readMinutes }} minute{{ $readMinutes === 1 ? '' : 's' }}</strong>
                        </div>
                    </div>

                    <div class="news-story-single__body">
                        @if($post->excerpt)
                            <div class="news-story-brief">
                                <span>Summary</span>
                                <p>{{ $post->excerpt }}</p>
                            </div>
                        @endif

                        <div class="news-article-body">
                            @foreach($paragraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>

                    <footer class="news-story-single__footer">
                        <div class="news-story-more">
                            <span class="news-story-card__label">More Updates</span>
                            <div class="news-story-related news-story-related--inline">
                                @forelse($latestPosts as $latest)
                                    <a href="{{ route('news.show', $latest->slug) }}">
                                        <img src="{{ $latest->imageUrl() }}" alt="{{ $latest->image_alt ?: $latest->title }}">
                                        <span>
                                            <strong>{{ $latest->title }}</strong>
                                            <small>{{ optional($latest->published_at)->format('M d, Y') ?: $latest->category }}</small>
                                        </span>
                                    </a>
                                @empty
                                    <p>More announcements will appear here soon.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="news-story-actions">
                            <a href="{{ route('news.index') }}">All News</a>
                            <a href="{{ url('/') }}#news">Homepage Updates</a>
                        </div>
                    </footer>
                </article>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
