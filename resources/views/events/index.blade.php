<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Campus events and academic calendar at {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}.">
    <title>Campus Events - {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-white text-slate-950">
    @include('partials.site-header')

    <main class="event-page bg-[#f8fbff]">
        @php
            $featuredEvent = $events->first();
            $listedEvents = $featuredEvent ? $events->getCollection()->skip(1) : collect();
        @endphp

        <section class="event-board-hero">
            <div class="container event-board-hero__inner">
                <div>
                    <span class="event-board-kicker">Campus Calendar</span>
                    <h1>What’s Happening at SCPS</h1>
                    <p>Academic sessions, student gatherings, seminars, and practical learning moments curated in one clean calendar.</p>
                </div>
                <div class="event-board-count">
                    <strong>{{ $events->total() }}</strong>
                    <span>{{ $events->total() === 1 ? 'event found' : 'events found' }}</span>
                </div>
            </div>
        </section>

        <section class="event-board-section">
            <div class="container event-board-layout">
                <aside class="event-filter-panel">
                    <span class="event-filter-panel__label">Find Events</span>
                    <h2>Refine the calendar</h2>
                    <form method="GET" action="{{ route('events.index') }}">
                        <label>
                            Category
                            <select name="category">
                                <option value="">All categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            Month
                            <select name="month">
                                <option value="">All months</option>
                                @foreach($months as $month)
                                    <option value="{{ $month['value'] }}" @selected($selectedMonth === $month['value'])>{{ $month['label'] }}</option>
                                @endforeach
                            </select>
                        </label>

                        <div class="event-filter-panel__actions">
                            <button type="submit">Apply</button>
                            <a href="{{ route('events.index') }}">Reset</a>
                        </div>
                    </form>
                </aside>

                <div class="event-board-main">
                    @if($featuredEvent)
                        <article class="campus-event-accent campus-event-accent--{{ $featuredEvent->accent ?: 'sky' }} event-feature-card">
                            <div class="event-feature-card__date">
                                <time>
                                    <strong>{{ $featuredEvent->starts_at->format('d') }}</strong>
                                    <span>{{ $featuredEvent->starts_at->format('M') }}</span>
                                </time>
                            </div>
                            <div class="event-feature-card__content">
                                <span class="campus-event-category event-feature-card__tag">{{ $featuredEvent->category }}</span>
                                <h2>{{ $featuredEvent->title }}</h2>
                                <p class="event-feature-card__meta">{{ $featuredEvent->venue ?: 'Venue pending' }} · {{ $featuredEvent->starts_at->format('F d, Y') }} · {{ $featuredEvent->starts_at->format('h:i A') }}</p>
                                @if($featuredEvent->description)
                                    <p class="event-feature-card__body">{{ $featuredEvent->description }}</p>
                                @endif
                            </div>
                        </article>

                        @if($listedEvents->isNotEmpty())
                            <div class="event-timeline">
                                @foreach($listedEvents as $event)
                                    <article class="campus-event-accent campus-event-accent--{{ $event->accent ?: 'sky' }} event-timeline-card">
                                        <time class="event-timeline-card__date">
                                            <strong>{{ $event->starts_at->format('d') }}</strong>
                                            <span>{{ $event->starts_at->format('M') }}</span>
                                        </time>
                                        <div>
                                            <span class="campus-event-category event-timeline-card__tag">{{ $event->category }}</span>
                                            <h3>{{ $event->title }}</h3>
                                            <p>{{ $event->venue ?: 'Venue pending' }} · {{ $event->starts_at->format('F d, Y') }} · {{ $event->starts_at->format('h:i A') }}</p>
                                            @if($event->description)
                                                <small>{{ $event->description }}</small>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="campus-events-empty">
                            <span>Campus Calendar</span>
                            <h3>No events match your filters.</h3>
                            <p>Try clearing the filters or check again after new campus events are published.</p>
                        </div>
                    @endif

                    @if($events->hasPages())
                        <div class="event-pagination mt-8">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
