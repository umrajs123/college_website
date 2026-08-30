<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Faculty profiles at {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}.">
    <title>Faculty Profiles - {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-white text-slate-950">
    @include('partials.site-header')

    <main class="bg-white">
        <section class="relative overflow-hidden bg-[#061a2f] pb-12 pt-28 text-white sm:pt-[120px] lg:pb-14 lg:pt-32">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_18%_20%,rgba(29,161,242,0.28),transparent_27%),radial-gradient(circle_at_88%_38%,rgba(45,212,191,0.14),transparent_26%)]"></div>
            <div class="container relative">
                <span class="mb-2 inline-flex items-center gap-3 text-[11px] font-black uppercase tracking-[0.20em] text-sky-300">
                    <span class="h-0.5 w-8 bg-sky-300"></span>
                    Faculty Profiles
                </span>
                <div class="grid gap-4 lg:grid-cols-[1.15fr_0.85fr] lg:items-end">
                    <div>
                        <h1 class="max-w-4xl text-3xl font-black leading-tight text-white sm:text-4xl lg:text-[42px]">Meet the Academic Mentors Behind SCPS</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-sky-50/80">Explore faculty profiles, teaching areas, mentoring focus, and academic guidance for pharmacy students.</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/10 p-3 text-white backdrop-blur">
                        <strong class="block text-xl font-black">{{ count($faculty) }}</strong>
                        <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.16em] text-sky-100/75">Featured mentors</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative -mt-7 pb-12">
            <div class="container">
                <div class="grid gap-4 md:grid-cols-3">
                    @forelse ($faculty as $member)
                        <a href="{{ route('faculty.show', $member->slug) }}" class="faculty-accent faculty-accent--{{ $member->accent ?: 'sky' }} faculty-accent-card group relative overflow-hidden rounded-lg border border-slate-200 bg-white shadow-[0_14px_34px_rgba(8,35,68,0.10)] transition duration-300 hover:-translate-y-1.5">
                            <div class="relative overflow-hidden">
                                <img class="h-[205px] w-full object-cover object-top transition duration-500 group-hover:scale-105" src="{{ $member->imageUrl() }}" alt="{{ $member->name }}">
                                <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-slate-950/76 to-transparent"></div>
                                <span class="faculty-accent-badge absolute bottom-3 left-3 rounded-full px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.13em] text-white">{{ $member->department }}</span>
                            </div>
                            <div class="p-4">
                                <strong class="faculty-listing-name block truncate text-slate-950">{{ $member->name }}</strong>
                                <p class="mt-1.5 text-[10px] font-black uppercase tracking-[0.13em] text-slate-500">{{ $member->designation }}</p>
                                <p class="mt-2.5 text-[13px] leading-5 text-slate-600">{{ $member->summary }}</p>
                                <span class="faculty-accent-link mt-3 inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-wide">
                                    View Profile
                                    <span class="transition group-hover:translate-x-1">-&gt;</span>
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="faculty-page-empty">
                            <span>Faculty Directory</span>
                            <h2>No faculty members are available right now.</h2>
                            <p>Once faculty profiles are added from the admin panel, they will be displayed here with their departments, designations, and detailed profile links.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
