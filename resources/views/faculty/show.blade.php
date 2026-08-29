<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $member->name }} faculty profile at {{ $siteSettings->site_name }} {{ $siteSettings->site_tagline }}.">
    <title>{{ $member->name }} - Faculty Profile</title>
    <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->faviconUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @include('partials.vite')
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body class="bg-slate-50 text-slate-950">
    @include('partials.site-header')

    <main class="faculty-accent faculty-accent--{{ $member->accent ?: 'sky' }} min-h-screen overflow-hidden">
        <section class="relative bg-gradient-to-b from-[#061a2f] via-[#082847] to-slate-50 pb-14 pt-32 text-white sm:pt-36 lg:pb-16 lg:pt-40">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_16%_18%,rgba(29,161,242,0.24),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(45,212,191,0.15),transparent_30%)]"></div>
            <div class="container relative grid gap-8 lg:grid-cols-[0.62fr_1.38fr] lg:items-center">
                <div class="relative mx-auto w-full max-w-[340px] lg:max-w-[360px]">
                    <div class="absolute -left-6 -top-6 h-40 w-40 rounded-full bg-sky-400/20 blur-3xl"></div>
                    <div class="relative overflow-hidden rounded-xl border border-white/12 bg-white/10 p-3 shadow-[0_24px_65px_rgba(0,0,0,0.28)] backdrop-blur">
                        <img class="h-[390px] w-full rounded-lg object-cover object-top" src="{{ $member->imageUrl() }}" alt="{{ $member->name }}">
                    </div>
                    <div class="absolute -bottom-5 right-4 rounded-lg border border-white/10 bg-white p-4 text-slate-950 shadow-[0_18px_44px_rgba(0,0,0,0.20)]">
                        <span class="faculty-accent-link block text-[11px] font-black uppercase tracking-[0.18em]">Department</span>
                        <strong class="mt-1 block text-lg font-black">{{ $member->department }}</strong>
                    </div>
                </div>

                <div>
                    <a href="{{ route('faculty.index') }}" class="faculty-accent-hero-link mb-5 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wide transition hover:!text-white">
                        &lt;- Faculty Profiles
                    </a>
                    <span class="faculty-accent-badge mb-4 inline-flex rounded-full px-4 py-2 text-xs font-black uppercase tracking-[0.18em] text-white">{{ $member->department }}</span>
                    <h1 class="max-w-4xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">{{ $member->name }}</h1>
                    <p class="mt-4 text-base font-bold text-sky-100/90 sm:text-lg">{{ $member->designation }}</p>
                    <p class="mt-5 max-w-3xl text-base leading-8 text-sky-50/80">{{ $member->summary }}</p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="mailto:{{ $member->email }}" class="faculty-accent-button inline-flex min-h-12 items-center justify-center rounded px-7 text-sm font-black uppercase tracking-wide !text-white transition hover:-translate-y-1">Email Faculty</a>
                        <a href="{{ url('/') }}#faculty" class="inline-flex min-h-12 items-center justify-center rounded border border-white/20 bg-white/10 px-7 text-sm font-black uppercase tracking-wide !text-white backdrop-blur transition hover:-translate-y-1 hover:bg-white hover:!text-slate-950">Homepage Faculty</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative bg-slate-50 py-12 sm:py-14 lg:py-16">
            <div class="container grid gap-7 lg:grid-cols-[1.1fr_0.9fr]">
                <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-[0_18px_45px_rgba(8,35,68,0.08)] sm:p-8">
                    <span class="mb-3 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.20em] text-sky-500">
                        <span class="h-0.5 w-8 bg-sky-500"></span>
                        Profile
                    </span>
                    <h2 class="text-3xl font-black leading-tight text-slate-950">Academic Biography</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">{{ $member->bio }}</p>

                    <div class="mt-7 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg bg-sky-50 p-5">
                            <span class="text-xs font-black uppercase tracking-[0.16em] text-sky-600">Education</span>
                            <strong class="mt-2 block text-base font-black leading-snug text-slate-950">{{ $member->education }}</strong>
                        </div>
                        <div class="rounded-lg bg-teal-50 p-5">
                            <span class="text-xs font-black uppercase tracking-[0.16em] text-teal-700">Experience</span>
                            <strong class="mt-2 block text-base font-black leading-snug text-slate-950">{{ $member->experience }}</strong>
                        </div>
                    </div>
                </article>

                <aside class="grid gap-5">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-[0_18px_45px_rgba(8,35,68,0.08)]">
                        <h2 class="text-2xl font-black text-slate-950">Contact Details</h2>
                        <div class="mt-5 grid gap-4 text-sm">
                            <div class="rounded-lg bg-slate-50 p-4">
                                <span class="block font-black uppercase tracking-[0.14em] text-slate-500">Email</span>
                                <a href="mailto:{{ $member->email }}" class="faculty-accent-link mt-1 block font-bold">{{ $member->email }}</a>
                            </div>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <span class="block font-black uppercase tracking-[0.14em] text-slate-500">Office</span>
                                <strong class="mt-1 block text-slate-950">{{ $member->office }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-[0_18px_45px_rgba(8,35,68,0.08)]">
                        <h2 class="text-2xl font-black text-slate-950">Teaching Areas</h2>
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($member->courses ?? [] as $course)
                                <span class="faculty-accent-chip rounded-full px-4 py-2 text-xs font-black uppercase tracking-wide">{{ $course }}</span>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="bg-white pb-16">
            <div class="container">
                <div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <span class="mb-3 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.20em] text-sky-500">
                            <span class="h-0.5 w-8 bg-sky-500"></span>
                            Expertise
                        </span>
                        <h2 class="text-3xl font-black text-slate-950">Specialized Focus</h2>
                    </div>
                    <a href="{{ route('faculty.index') }}" class="inline-flex min-h-11 items-center justify-center rounded bg-slate-950 px-5 text-sm font-black uppercase tracking-wide !text-white transition hover:-translate-y-0.5 hover:bg-sky-500">Browse All Faculty</a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($member->specialties ?? [] as $specialty)
                        <div class="group rounded-lg border border-slate-200 bg-white p-5 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition hover:-translate-y-1 hover:border-sky-200 hover:shadow-[0_24px_50px_rgba(29,161,242,0.14)]">
                            <span class="faculty-accent-badge mb-4 grid h-11 w-11 place-items-center rounded-full text-sm font-black text-white transition group-hover:rotate-3 group-hover:scale-105">{{ $loop->iteration }}</span>
                            <strong class="block text-base font-black leading-snug text-slate-950">{{ $specialty }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-gradient-to-b from-sky-50 via-white to-white py-12 text-slate-950">
            <div class="pointer-events-none absolute -right-24 top-0 h-56 w-56 rounded-full bg-sky-100/80 blur-3xl"></div>
            <div class="container">
                <div class="mb-7 flex items-center justify-between gap-4">
                    <h2 class="text-2xl font-black text-slate-950">Other Faculty Members</h2>
                    <a href="{{ route('faculty.index') }}" class="text-sm font-black uppercase tracking-wide !text-sky-600 transition hover:!text-sky-500">View all</a>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($faculty as $other)
                        @continue($other->id === $member->id)
                        <a href="{{ route('faculty.show', $other->slug) }}" class="faculty-accent faculty-accent--{{ $other->accent ?: 'sky' }} faculty-accent-card group flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-4 !text-slate-950 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition hover:-translate-y-1">
                            <img class="faculty-accent-avatar h-16 w-16 rounded-full object-cover object-top" src="{{ $other->imageUrl() }}" alt="{{ $other->name }}">
                            <span>
                                <strong class="block font-black text-slate-950">{{ $other->name }}</strong>
                                <small class="faculty-accent-link mt-1 block font-bold uppercase tracking-[0.14em]">{{ $other->department }}</small>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>
