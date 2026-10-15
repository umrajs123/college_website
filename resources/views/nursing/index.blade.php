<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $hero?->body ?: 'Explore nursing education at SCPS.' }}">
    @php($siteSettings = \App\Models\SiteSetting::current())
    <title>{{ $hero?->title ?: 'Nursing' }} - {{ $siteSettings->site_name }}</title>
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

    <main class="nursing-page">
        <section class="nursing-hero">
            <div class="container">
                <nav class="nursing-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <span>Nursing</span>
                </nav>
                <div class="nursing-hero__panel">
                    <div class="nursing-hero__copy">
                        <span class="nursing-kicker">{{ $hero?->eyebrow ?: 'School of Nursing' }}</span>
                        <h1>{{ $hero?->title ?: 'Nursing at SCPS' }} <span class="nursing-hero__stethoscope" aria-hidden="true"><svg viewBox="0 0 48 56" fill="none"><path d="M12 8v10a9 9 0 0 0 18 0V8m-21 0h6m12 0h6M21 27v3a8 8 0 0 0 8 8h4" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 8v5m18-5v5" stroke="#c62828" stroke-width="3" stroke-linecap="round"/><circle cx="38" cy="38" r="5" fill="#c62828"/><circle cx="38" cy="38" r="2" fill="#fff"/><path d="M38 43v2a6 6 0 0 1-6 6h-3" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg></span></h1>
                        <p>{{ $hero?->body ?: 'Explore a nursing education built around knowledge, practical preparation, and compassionate care.' }}</p>
                        <div class="nursing-actions">
                            <a href="{{ $hero?->button_url ?: $siteSettings->admissions_url ?: url('/#contact') }}">{{ $hero?->button_label ?: 'Explore Admissions' }}</a>
                            <a href="{{ $hero?->secondary_button_url ?: '#nursing-college' }}">{{ $hero?->secondary_button_label ?: 'Discover Our College' }}</a>
                        </div>
                    </div>
                    <div class="nursing-hero__visual">
                        <div class="nursing-hero__image">
                            <img src="{{ $hero?->imageUrl(asset('images/nursing-care.jpg')) }}" alt="Nursing professional ready to provide compassionate care" fetchpriority="high">
                        </div>
                        <div class="nursing-hero__note">
                            <span aria-hidden="true">✚</span>
                            <div><strong>Learn to care</strong><small>Lead with knowledge. Serve with heart.</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="nursing-content" id="nursing-college">
            <div class="container">
                @php($collegeInfo = $sections->where('section_type', 'content'))
                @if($collegeInfo->isNotEmpty())
                    <div class="nursing-story-grid">
                        <div class="nursing-section-intro">
                            <span class="nursing-kicker">{{ $collegeInfo->first()->eyebrow ?: 'The Nursing College' }}</span>
                            <h2>{{ $collegeInfo->first()->title }}</h2>
                            <span class="nursing-title-rule" aria-hidden="true"></span>
                        </div>
                        <div class="nursing-story-copy">
                            @foreach(preg_split("/\r\n|\n|\r/", trim($collegeInfo->first()->body)) as $paragraph)
                                @if(trim($paragraph) !== '')
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        </div>
                        <img class="nursing-story-image" src="{{ $collegeInfo->first()->imageUrl(asset('images/nursing-college.jpg')) }}" alt="{{ $collegeInfo->first()->title }} at SCPS">
                    </div>
                    @foreach($collegeInfo->skip(1) as $section)
                        <article class="nursing-extra-section">
                            <span class="nursing-kicker">{{ $section->eyebrow }}</span>
                            <h2>{{ $section->title }}</h2>
                            @foreach(preg_split("/\r\n|\n|\r/", trim($section->body)) as $paragraph)
                                @if(trim($paragraph) !== '')
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        </article>
                    @endforeach
                @endif

                @php($features = $sections->where('section_type', 'feature'))
                @if($features->isNotEmpty())
                    <aside class="nursing-care-principle" aria-label="A principle of thoughtful nursing care">
                        <div class="nursing-care-principle__copy">
                            <span class="nursing-kicker">A principle of thoughtful care</span>
                            <h2>See the person, not only the condition.</h2>
                            <p>Good care begins with understanding each person’s needs, listening to their concerns, and treating them with dignity.</p>
                        </div>
                        <ol class="nursing-care-principle__steps">
                            <li><span>01</span> Listen closely</li>
                            <li><span>02</span> Respond thoughtfully</li>
                            <li><span>03</span> Care with dignity</li>
                        </ol>
                    </aside>
                    <div class="nursing-features-head">
                        <div>
                            <span class="nursing-kicker">Your nursing journey</span>
                            <h2>Learn with purpose. Care with confidence.</h2>
                        </div>
                        <p>Explore the values and experiences that shape a thoughtful nursing education.</p>
                    </div>
                    <div class="nursing-feature-grid">
                        @foreach($features as $feature)
                            <article class="nursing-feature-card">
                                <span class="nursing-feature-icon {{ $feature->icon_label === 'pulse' ? 'nursing-feature-icon--red' : '' }}" data-icon="{{ $feature->icon_label }}" aria-hidden="true">
                                    @switch($feature->icon_label)
                                        @case('heart')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M20.8 8.8c0 5.1-8.8 10-8.8 10S3.2 13.9 3.2 8.8A4.7 4.7 0 0 1 12 6.3a4.7 4.7 0 0 1 8.8 2.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.5 11h4l1.5-2.5 2.2 5 1.5-2.5h5.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('stethoscope')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M6 4v5a4 4 0 0 0 8 0V4M4 4h4M12 4h4m-6 9v1a4 4 0 0 0 8 0v-1m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm-4 4v1a4 4 0 0 0 8 0v-1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('shield')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.6-3 8-7 10-4-2-7-5.4-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m8.5 12 2.2 2.2 4.8-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('people')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20m6-8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm6-6.7a3.5 3.5 0 0 1 0 6.8m2 3.1a3.5 3.5 0 0 1 2 3.2V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('spark')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="m12 3 1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7L12 3Zm6 12 .9 2.1L21 18l-2.1.9L18 21l-.9-2.1L15 18l2.1-.9L18 15ZM5 15l.8 1.7L7.5 17.5l-1.7.8L5 20l-.8-1.7-1.7-.8 1.7-.8L5 15Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @case('pulse')
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M3 12h4l2.2-6 4.2 12 2.2-6H21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            @break
                                        @default
                                            {{ $feature->icon_label ?: '✚' }}
                                    @endswitch
                                </span>
                                @if($feature->image_url)
                                    <img class="nursing-feature-image" src="{{ $feature->imageUrl() }}" alt="{{ $feature->title }}">
                                @endif
                                <span class="nursing-feature-eyebrow">{{ $feature->eyebrow }}</span>
                                <h3>{{ $feature->title }}</h3>
                                <p>{{ $feature->body }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif

                @php($callToAction = $sections->firstWhere('section_type', 'cta'))
                @if($callToAction)
                    <div class="nursing-cta">
                        <div>
                            <span class="nursing-kicker">{{ $callToAction->eyebrow ?: 'Begin your journey' }}</span>
                            <h2>{{ $callToAction->title }}</h2>
                            <p>{{ $callToAction->body }}</p>
                        </div>
                        <a href="{{ $callToAction->button_url ?: $siteSettings->admissions_url ?: url('/#contact') }}">{{ $callToAction->button_label ?: 'Talk to Admissions' }} <span aria-hidden="true">→</span></a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
