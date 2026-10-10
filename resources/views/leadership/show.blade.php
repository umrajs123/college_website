<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $message->title }} — a message from the {{ $message->role }} at {{ $siteSettings->site_name }}.">
    <title>{{ $message->title }} - {{ $siteSettings->site_name }}</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-slate-50 text-slate-950">
    @include('partials.site-header')

    <main class="leadership-detail leadership-detail--{{ $message->accent }}">
        <section class="leadership-detail__hero">
            <div class="leadership-detail__hero-inner">
                <div class="leadership-detail__portrait">
                    <img src="{{ $message->imageUrl() }}" alt="{{ $message->role }} portrait">
                </div>

                <div class="leadership-detail__intro">
                    <a href="{{ url('/') }}#leadership" class="leadership-detail__back">
                        <span aria-hidden="true">&larr;</span> Leadership Messages
                    </a>
                    <span class="leadership-detail__role">{{ $message->role }}</span>
                    <h1>{{ $message->title }}</h1>
                    @if($message->subtitle)
                        <p class="leadership-detail__subtitle">{{ $message->subtitle }}</p>
                    @endif
                </div>
            </div>
        </section>

        <section class="leadership-detail__content">
            <article class="leadership-detail__message">
                <span class="leadership-detail__label">
                    <span aria-hidden="true"></span>
                    A Message from the {{ $message->role }}
                </span>
                <div class="leadership-detail__text">{{ $message->message }}</div>

                @if(! empty($message->tags))
                    <div class="leadership-detail__tags">
                        @foreach($message->tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </article>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
