@extends('admin.layouts.app')

@section('title', 'SCPS Admin Dashboard')
@section('eyebrow', 'Website Overview')
@section('page_title', 'Dashboard')

@section('content')
    @php
        $publishedTotal = $activeHeroSlideCount
            + $activeFacultyCount
            + $activeEventCount
            + $activeNewsCount
            + $activeLeadershipCount
            + $activeProgramCount
            + $activeStatCount
            + $activeStudentVoiceCount
            + $activeFacilityCount
            + $activeAboutCount
            + $activeCampusLifeCount;

        $draftTotal = ($heroSlideCount - $activeHeroSlideCount)
            + ($facultyCount - $activeFacultyCount)
            + ($eventCount - $activeEventCount)
            + ($newsCount - $activeNewsCount)
            + ($leadershipCount - $activeLeadershipCount)
            + ($programCount - $activeProgramCount)
            + ($statCount - $activeStatCount)
            + ($studentVoiceCount - $activeStudentVoiceCount)
            + ($facilityCount - $activeFacilityCount)
            + ($aboutCount - $activeAboutCount)
            + ($campusLifeCount - $activeCampusLifeCount);

        $contentChart = collect([
            ['label' => 'Hero Slides', 'total' => $heroSlideCount, 'active' => $activeHeroSlideCount],
            ['label' => 'Faculty', 'total' => $facultyCount, 'active' => $activeFacultyCount],
            ['label' => 'Events', 'total' => $eventCount, 'active' => $activeEventCount],
            ['label' => 'News', 'total' => $newsCount, 'active' => $activeNewsCount],
            ['label' => 'Leadership', 'total' => $leadershipCount, 'active' => $activeLeadershipCount],
            ['label' => 'Programs', 'total' => $programCount, 'active' => $activeProgramCount],
            ['label' => 'Stats', 'total' => $statCount, 'active' => $activeStatCount],
            ['label' => 'Voices', 'total' => $studentVoiceCount, 'active' => $activeStudentVoiceCount],
            ['label' => 'Facilities', 'total' => $facilityCount, 'active' => $activeFacilityCount],
            ['label' => 'About', 'total' => $aboutCount, 'active' => $activeAboutCount],
            ['label' => 'Campus Life', 'total' => $campusLifeCount, 'active' => $activeCampusLifeCount],
        ]);

        $maxChartTotal = max(1, $contentChart->max('total'));
        $chartCount = max(1, $contentChart->count() - 1);
        $chartMax = max(1, $contentChart->max(fn ($item) => max($item['total'], $item['active'])));
        $plotTop = 28;
        $plotBottom = 222;
        $plotHeight = $plotBottom - $plotTop;
        $totalPoints = $contentChart->values()->map(function ($item, $index) use ($chartCount, $chartMax, $plotBottom, $plotHeight) {
            $x = round(($index / $chartCount) * 1000, 2);
            $y = round($plotBottom - (($item['total'] / $chartMax) * $plotHeight), 2);
            return $x.','.$y;
        })->implode(' ');
        $activePoints = $contentChart->values()->map(function ($item, $index) use ($chartCount, $chartMax, $plotBottom, $plotHeight) {
            $x = round(($index / $chartCount) * 1000, 2);
            $y = round($plotBottom - (($item['active'] / $chartMax) * $plotHeight), 2);
            return $x.','.$y;
        })->implode(' ');
    @endphp

    <section class="admin-status-strip">
        <div>
            <span>{{ now()->format('l, F d') }}</span>
            <h2>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}. Your website content is ready to manage.</h2>
        </div>
        <div class="admin-status-strip__metrics">
            <article>
                <strong>{{ $publishedTotal }}</strong>
                <small>Published items</small>
            </article>
            <article>
                <strong>{{ $draftTotal }}</strong>
                <small>Hidden drafts</small>
            </article>
        </div>
    </section>

    <section class="admin-stats">
        <article>
            <span>{{ $heroSlideCount }}</span>
            <strong>Hero slides</strong>
            <small>{{ $activeHeroSlideCount }} active slides appear in the homepage hero.</small>
        </article>
        <article>
            <span>{{ $facultyCount }}</span>
            <strong>Faculty profiles</strong>
            <small>{{ $activeFacultyCount }} active profiles are visible publicly.</small>
        </article>
        <article>
            <span>{{ $eventCount }}</span>
            <strong>Campus events</strong>
            <small>{{ $activeEventCount }} active events are visible on the homepage.</small>
        </article>
        <article>
            <span>{{ $newsCount }}</span>
            <strong>News posts</strong>
            <small>{{ $activeNewsCount }} active posts are visible publicly.</small>
        </article>
        <article>
            <span>{{ $leadershipCount }}</span>
            <strong>Leadership records</strong>
            <small>{{ $activeLeadershipCount }} active messages are visible publicly.</small>
        </article>
        <article>
            <span>{{ $programCount }}</span>
            <strong>Academic programs</strong>
            <small>{{ $activeProgramCount }} active programs are visible on the homepage.</small>
        </article>
        <article>
            <span>{{ $statCount }}</span>
            <strong>Stats counters</strong>
            <small>{{ $activeStatCount }} active counters animate on the homepage.</small>
        </article>
        <article>
            <span>{{ $studentVoiceCount }}</span>
            <strong>Student voices</strong>
            <small>{{ $activeStudentVoiceCount }} active testimonials appear in the slider.</small>
        </article>
        <article>
            <span>{{ $facilityCount }}</span>
            <strong>Facilities</strong>
            <small>{{ $activeFacilityCount }} active facility cards appear in the carousel.</small>
        </article>
        <article>
            <span>{{ $aboutCount }}</span>
            <strong>About blocks</strong>
            <small>{{ $activeAboutCount }} active About blocks are available for the homepage.</small>
        </article>
        <article>
            <span>{{ $campusLifeCount }}</span>
            <strong>Campus Life</strong>
            <small>{{ $activeCampusLifeCount }} active Campus Life section is available for the homepage.</small>
        </article>
    </section>

    <section class="admin-content-graph admin-content-line-graph">
        <div class="admin-card-head">
            <div>
                <span class="admin-kicker">Content Analytics</span>
                <h2>Content Growth Line Graph</h2>
                <p>Line graph plotted from real module counts in the dashboard: total records and published records.</p>
            </div>
            <div class="admin-graph-legend">
                <span><i></i> Published</span>
                <span><i></i> Total</span>
            </div>
        </div>

        <div class="admin-line-chart-wrap">
            <div class="admin-line-chart-scale">
                <span>{{ $chartMax }}</span>
                <span>{{ round($chartMax / 2) }}</span>
                <span>0</span>
            </div>
            <div class="admin-line-chart">
                <svg viewBox="0 0 1000 260" role="img" aria-label="Published and total content line graph" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="adminPublishedLine" x1="0" x2="1" y1="0" y2="0">
                            <stop offset="0%" stop-color="#0ea5e9" />
                            <stop offset="100%" stop-color="#14b8a6" />
                        </linearGradient>
                        <linearGradient id="adminPublishedArea" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#0ea5e9" stop-opacity="0.22" />
                            <stop offset="100%" stop-color="#0ea5e9" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    <g class="admin-line-chart__grid">
                        <line x1="0" y1="28" x2="1000" y2="28" />
                        <line x1="0" y1="125" x2="1000" y2="125" />
                        <line x1="0" y1="222" x2="1000" y2="222" />
                    </g>
                    <polygon class="admin-line-chart__area" points="{{ $activePoints }} 1000,222 0,222"></polygon>
                    <polyline class="admin-line-chart__total" points="{{ $totalPoints }}"></polyline>
                    <polyline class="admin-line-chart__active" points="{{ $activePoints }}"></polyline>
                    @foreach($contentChart->values() as $item)
                        @php
                            $x = round(($loop->index / $chartCount) * 1000, 2);
                            $activeY = round($plotBottom - (($item['active'] / $chartMax) * $plotHeight), 2);
                            $totalY = round($plotBottom - (($item['total'] / $chartMax) * $plotHeight), 2);
                        @endphp
                        <circle class="admin-line-chart__dot admin-line-chart__dot--total" cx="{{ $x }}" cy="{{ $totalY }}" r="5"></circle>
                        <circle class="admin-line-chart__dot admin-line-chart__dot--active" cx="{{ $x }}" cy="{{ $activeY }}" r="6"></circle>
                    @endforeach
                </svg>
            </div>
        </div>

        <div class="admin-line-chart-labels">
            @foreach($contentChart as $item)
                <span title="{{ $item['label'] }}">{{ \Illuminate\Support\Str::limit($item['label'], 10, '') }}</span>
            @endforeach
        </div>
    </section>
@endsection
