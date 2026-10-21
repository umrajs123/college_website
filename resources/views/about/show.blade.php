<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($aboutSection->body ?: $aboutSection->heading), 160) }}">
    <title>{{ $aboutSection->heading }} - {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}</title>
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

    <main class="about-us-page campus-event-accent campus-event-accent--{{ $aboutSection->accent ?: 'sky' }}">
        <section class="about-us-hero">
            <div class="container">
                <nav class="about-us-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>About Us</span>
                </nav>

                <div class="about-us-card">
                    <div class="about-us-media">
                        <img src="{{ $aboutSection->imageUrl() }}" alt="{{ $aboutSection->image_alt ?: $aboutSection->heading }}">
                        @if($aboutSection->badge_value || $aboutSection->badge_label)
                            <div class="about-us-badge">
                                @if($aboutSection->badge_value)
                                    <strong>{{ $aboutSection->badge_value }}</strong>
                                @endif
                                @if($aboutSection->badge_label)
                                    <span>{{ $aboutSection->badge_label }}</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="about-us-copy">
                        <span class="about-us-eyebrow">{{ $aboutSection->eyebrow }}</span>
                        <h1>{{ $aboutSection->heading }}</h1>

                        @forelse($paragraphs as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @empty
                            <p>More information about the college will be added soon.</p>
                        @endforelse

                        @if(! empty($aboutSection->features))
                            <div class="about-us-features">
                                @foreach($aboutSection->features as $feature)
                                    <div class="about-feature-item campus-event-accent campus-event-accent--{{ $feature['accent'] ?? 'sky' }}">
                                        <span aria-hidden="true">&check;</span>
                                        {{ $feature['text'] ?? '' }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($aboutSection->button_label)
                            <a class="about-us-cta" href="{{ $aboutSection->button_url ?: route('home').'#contact' }}">{{ $aboutSection->button_label }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
