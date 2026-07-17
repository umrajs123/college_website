<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $program->description ?: $program->title }}">
    <title>{{ $program->title }} - Swat College of Pharmaceutical Sciences</title>
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
        $sections = collect([
            'Program Overview' => $program->overview ?: $program->description,
            'Learning Focus' => $program->learning_focus,
            'Career Direction' => $program->career_scope,
        ])->filter(fn ($value) => filled($value));

        $paragraphsFor = function (?string $text) {
            return collect(preg_split("/\r\n|\n|\r/", trim((string) $text)))
                ->map(fn ($paragraph) => trim($paragraph))
                ->filter()
                ->values();
        };
    @endphp

    <main class="program-profile campus-event-accent campus-event-accent--{{ $program->accent ?: 'sky' }}">
        <section class="program-profile-hero">
            <div class="container">
                <nav class="program-profile-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ url('/') }}#programs">Academic Areas</a>
                    <span>{{ $program->title }}</span>
                </nav>

                <div class="program-profile-hero__panel">
                    <div class="program-profile-hero__copy">
                        <span class="program-profile-kicker">Academic Career</span>
                        <h1>{{ $program->title }}</h1>
                        <p>{{ $program->description ?: 'Detailed program information will be updated soon from the admin panel.' }}</p>
                        <div class="program-profile-actions">
                            <a href="{{ url('/') }}#admissions">Apply Now</a>
                            <a href="{{ url('/') }}#programs">Explore Programs</a>
                        </div>
                    </div>

                    <aside class="program-profile-card">
                        <span class="program-profile-card__icon">{{ $program->icon_label }}</span>
                        <div>
                            <small>Program Snapshot</small>
                            <strong>{{ $program->title }}</strong>
                        </div>
                        <dl>
                            <div>
                                <dt>Duration</dt>
                                <dd>{{ $program->duration ?: 'To be announced' }}</dd>
                            </div>
                            <div>
                                <dt>Eligibility</dt>
                                <dd>{{ $program->eligibility ?: 'Admissions office will update details soon' }}</dd>
                            </div>
                            <div>
                                <dt>Mode</dt>
                                <dd>On-campus learning</dd>
                            </div>
                        </dl>
                    </aside>
                </div>
            </div>
        </section>

        <section class="program-profile-body">
            <div class="container">
                <div class="program-profile-grid">
                    <article class="program-profile-article">
                        @forelse($sections as $heading => $content)
                            <section>
                                <span>{{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}</span>
                                <h2>{{ $heading }}</h2>
                                @foreach($paragraphsFor($content) as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </section>
                        @empty
                            <section>
                                <span>01</span>
                                <h2>Details Coming Soon</h2>
                                <p>This program page is ready. Add overview, learning focus, and career scope from the admin panel to complete the public profile.</p>
                            </section>
                        @endforelse
                    </article>

                    <aside class="program-profile-side">
                        <div class="program-profile-mini">
                            <span>Quick Contact</span>
                            <h3>Need guidance?</h3>
                            <p>Our admissions team can help students understand eligibility, program fit, and next steps.</p>
                            <a href="{{ url('/') }}#contact">Contact Admissions</a>
                        </div>

                        <div class="program-profile-related">
                            <span>More Academic Areas</span>
                            @forelse($programs as $otherProgram)
                                <a class="campus-event-accent campus-event-accent--{{ $otherProgram->accent ?: 'sky' }}" href="{{ $otherProgram->publicUrl() }}">
                                    <strong>{{ $otherProgram->icon_label }}</strong>
                                    <span>{{ $otherProgram->title }}</span>
                                </a>
                            @empty
                                <p>More programs will appear here after they are published.</p>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
