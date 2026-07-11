<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Swat College of Pharmaceutical Sciences - pharmacy education, research, clinical training, and student life in Swat.">
    <title>Swat College of Pharmaceutical Sciences</title>
    <link rel="icon" type="image/png" href="{{ asset('images/scps-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/scps-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/scps.css') }}?v={{ filemtime(public_path('css/scps.css')) }}">
</head>
<body>
    @include('partials.site-header')

    <main>
        <section class="scps-active-hero relative overflow-hidden bg-slate-950 pb-8 text-white sm:pb-10 lg:pb-12" aria-label="Featured college highlights">
            <div class="relative min-h-[650px] sm:min-h-[675px] lg:min-h-[710px]" data-slider>
                @foreach($heroSlides as $slide)
                    <article data-hero-slide class="{{ $loop->first ? 'active ' : '' }}absolute inset-0">
                        <img class="absolute inset-0 h-full w-full object-cover" src="{{ $slide->imageUrl() }}" alt="{{ $slide->image_alt ?: $slide->heading }}">
                        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,18,35,0.88),rgba(5,18,35,0.58)_44%,rgba(5,18,35,0.76)),linear-gradient(180deg,rgba(5,18,35,0.68),rgba(5,18,35,0.2)_40%,rgba(5,18,35,0.95))]"></div>
                        <div class="container relative z-10 flex min-h-[650px] items-center pt-6 sm:min-h-[675px] sm:pt-8 lg:min-h-[710px] lg:pt-10">
                            <div class="scps-hero-copy mx-auto max-w-5xl text-center">
                                <span class="mb-3 inline-flex items-center justify-center text-sm font-black uppercase tracking-[0.28em] text-sky-400 sm:text-base">{{ $slide->eyebrow }}</span>
                                <h1 class="mx-auto max-w-5xl text-4xl font-black leading-[1.05] text-white drop-shadow-[0_10px_30px_rgba(0,0,0,0.35)] sm:text-5xl lg:text-6xl">{{ $slide->heading }}</h1>
                                <p class="mx-auto mt-5 max-w-3xl text-base font-medium leading-8 text-white/90 sm:text-lg">{{ $slide->body }}</p>
                                @if($slide->primary_label || $slide->secondary_label)
                                    <div class="mt-7 flex flex-wrap items-center justify-center gap-4">
                                        @if($slide->primary_label)
                                            <a href="{{ $slide->primary_url ?: '#' }}" class="inline-flex min-h-[52px] items-center justify-center rounded-md bg-[#1da1f2] px-8 py-4 text-sm font-black uppercase tracking-wide text-white shadow-[0_16px_36px_rgba(29,161,242,0.35)] transition duration-300 hover:-translate-y-1 hover:bg-sky-400 hover:shadow-[0_22px_44px_rgba(29,161,242,0.45)]">{{ $slide->primary_label }}</a>
                                        @endif
                                        @if($slide->secondary_label)
                                            <a href="{{ $slide->secondary_url ?: '#' }}" class="hero-secondary-cta inline-flex min-h-[52px] items-center justify-center rounded-md border border-white/40 px-8 py-4 text-sm font-black uppercase tracking-wide text-white transition duration-300 hover:-translate-y-1 hover:border-white hover:bg-white hover:text-slate-950">{{ $slide->secondary_label }}</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach

                <button class="absolute left-4 top-1/2 z-20 grid h-14 w-14 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-4xl leading-none text-white backdrop-blur-md transition duration-300 hover:bg-white/20 sm:left-8 lg:h-20 lg:w-20" type="button" data-prev aria-label="Previous slide">&lsaquo;</button>
                <button class="absolute right-4 top-1/2 z-20 grid h-14 w-14 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-4xl leading-none text-white backdrop-blur-md transition duration-300 hover:bg-white/20 sm:right-8 lg:h-20 lg:w-20" type="button" data-next aria-label="Next slide">&rsaquo;</button>
            </div>

            <div class="hero-cards container" aria-label="College highlights">
                <a href="#programs" class="quick-card reveal">
                    <span class="quick-card__icon">Rx</span>
                    <span>
                        <strong>5 focused programs</strong>
                        <small>Choose the right pharmacy pathway</small>
                    </span>
                </a>
                <a href="#labs" class="quick-card reveal">
                    <span class="quick-card__icon">Lab</span>
                    <span>
                        <strong>Expert Instruction</strong>
                        <small>Learn from qualified faculty</small>
                    </span>
                </a>
                <a href="#admissions" class="quick-card reveal">
                    <span class="quick-card__icon">&check;</span>
                    <span>
                        <strong>Admissions Support</strong>
                        <small>Apply with clear guidance</small>
                    </span>
                </a>
            </div>
        </section>

        <section class="leadership-section">
            <div class="container">
                <div class="leadership-heading reveal">
                    <span>Leadership Messages</span>
                    <h2>Messages From Our Leadership</h2>
                    <p>Clear academic direction, student care, and professional discipline guide the culture at SCPS.</p>
                </div>
            </div>

            <div class="leadership-split">
                @forelse($leadershipMessages as $message)
                <article class="leadership-card leadership-card--{{ $message->accent }} reveal">
                    <div class="leadership-card__accent">
                        <div>
                            <span>{{ $message->role }}</span>
                            <h3>{{ $message->title }}</h3>
                            @if($message->subtitle)
                                <small>{{ $message->subtitle }}</small>
                            @endif
                        </div>
                        <img src="{{ $message->imageUrl() }}" alt="{{ $message->role }} portrait">
                    </div>
                    {{--
                    <div class="leadership-card__head">
                        <div>
                            <span class="leadership-card__role">{{ $message->role }}</span>
                            <h3>{{ $message->title }}</h3>
                            <small>{{ $message->subtitle }}</small>
                        </div>
                        <img src="{{ $message->imageUrl() }}" alt="{{ $message->role }} portrait">
                    </div>
                    --}}
                    <p>{{ $message->message }}</p>
                    @if(! empty($message->tags))
                    <div class="leadership-card__tags">
                        @foreach($message->tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </article>
                @empty
                    <div class="leadership-empty reveal">
                        <span>Content Pending</span>
                        <h3>No leadership messages are available right now.</h3>
                        <p>Messages from the Director and Principal will appear here after they are published from the admin panel.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="programs" class="relative overflow-hidden bg-gradient-to-b from-white via-sky-50/70 to-white py-14 sm:py-16 lg:py-18">
            <div class="pointer-events-none absolute -right-10 top-8 h-44 w-44 rounded-full border-[26px] border-sky-200/40"></div>
            <div class="pointer-events-none absolute -left-16 bottom-4 h-52 w-52 rounded-full bg-sky-100/60 blur-3xl"></div>
            <div class="container relative">
                <div class="reveal mx-auto mb-9 max-w-3xl text-center">
                    <span class="mb-3 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                        Academic Areas
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                    </span>
                    <h2 class="mb-0 text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Focused Pathways in Pharmaceutical Sciences</h2>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="reveal group relative min-h-[255px] overflow-hidden rounded-lg border border-slate-200/80 bg-white/95 p-6 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition duration-300 hover:-translate-y-2 hover:border-sky-300 hover:shadow-[0_24px_52px_rgba(8,35,68,0.14)]">
                        <div class="absolute inset-0 bg-gradient-to-br from-sky-100/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                        <div class="absolute -bottom-12 -right-12 h-32 w-32 rounded-full border-[18px] border-sky-200/50 transition duration-300 group-hover:scale-110"></div>
                        <span class="relative z-10 mb-5 grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-[#0b4da2] to-[#1da1f2] text-sm font-black text-white shadow-[0_14px_28px_rgba(29,161,242,0.28)] transition duration-300 group-hover:-translate-y-1 group-hover:-rotate-3">Rx</span>
                        <h3 class="relative z-10 mb-3 text-xl font-extrabold leading-tight text-slate-950">Doctor of Pharmacy</h3>
                        <p class="relative z-10 mb-5 text-sm leading-7 text-slate-600">Core pharmaceutical education with clinical and community practice foundations.</p>
                        <a href="#" class="relative z-10 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wide text-sky-500">Read More <span class="transition group-hover:translate-x-1">→</span></a>
                    </article>
                    <article class="reveal group relative min-h-[255px] overflow-hidden rounded-lg border border-slate-200/80 bg-white/95 p-6 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition duration-300 hover:-translate-y-2 hover:border-teal-300 hover:shadow-[0_24px_52px_rgba(8,35,68,0.14)]">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-100/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                        <div class="absolute -bottom-12 -right-12 h-32 w-32 rounded-full border-[18px] border-teal-200/50 transition duration-300 group-hover:scale-110"></div>
                        <span class="relative z-10 mb-5 grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-teal-700 to-teal-400 text-lg font-black text-white shadow-[0_14px_28px_rgba(20,184,166,0.25)] transition duration-300 group-hover:-translate-y-1 group-hover:-rotate-3">μ</span>
                        <h3 class="relative z-10 mb-3 text-xl font-extrabold leading-tight text-slate-950">Pharmaceutics</h3>
                        <p class="relative z-10 mb-5 text-sm leading-7 text-slate-600">Dosage forms, formulation principles, quality assurance, and industrial practice.</p>
                        <a href="#" class="relative z-10 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wide text-teal-600">Read More <span class="transition group-hover:translate-x-1">→</span></a>
                    </article>
                    <article class="reveal group relative min-h-[255px] overflow-hidden rounded-lg border border-slate-200/80 bg-white/95 p-6 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition duration-300 hover:-translate-y-2 hover:border-indigo-300 hover:shadow-[0_24px_52px_rgba(8,35,68,0.14)]">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-100/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                        <div class="absolute -bottom-12 -right-12 h-32 w-32 rounded-full border-[18px] border-indigo-200/50 transition duration-300 group-hover:scale-110"></div>
                        <span class="relative z-10 mb-5 grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-indigo-700 to-[#1da1f2] text-lg font-black text-white shadow-[0_14px_28px_rgba(79,70,229,0.25)] transition duration-300 group-hover:-translate-y-1 group-hover:-rotate-3">⚕</span>
                        <h3 class="relative z-10 mb-3 text-xl font-extrabold leading-tight text-slate-950">Clinical Pharmacy</h3>
                        <p class="relative z-10 mb-5 text-sm leading-7 text-slate-600">Patient-centered medication use, safety, counseling, and therapeutic decision-making.</p>
                        <a href="#" class="relative z-10 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wide text-indigo-600">Read More <span class="transition group-hover:translate-x-1">→</span></a>
                    </article>
                    <article class="reveal group relative min-h-[255px] overflow-hidden rounded-lg border border-slate-200/80 bg-white/95 p-6 shadow-[0_14px_34px_rgba(8,35,68,0.08)] transition duration-300 hover:-translate-y-2 hover:border-cyan-300 hover:shadow-[0_24px_52px_rgba(8,35,68,0.14)]">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-100/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                        <div class="absolute -bottom-12 -right-12 h-32 w-32 rounded-full border-[18px] border-cyan-200/50 transition duration-300 group-hover:scale-110"></div>
                        <span class="relative z-10 mb-5 grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-cyan-700 to-sky-400 text-xs font-black text-white shadow-[0_14px_28px_rgba(6,182,212,0.25)] transition duration-300 group-hover:-translate-y-1 group-hover:-rotate-3">DNA</span>
                        <h3 class="relative z-10 mb-3 text-xl font-extrabold leading-tight text-slate-950">Pharmacology</h3>
                        <p class="relative z-10 mb-5 text-sm leading-7 text-slate-600">Drug action, toxicity, therapeutic response, and evidence-based medicine.</p>
                        <a href="#" class="relative z-10 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wide text-cyan-600">Read More <span class="transition group-hover:translate-x-1">→</span></a>
                    </article>
                </div>
            </div>
        </section>

        <section id="about" class="relative overflow-hidden bg-gradient-to-br from-white via-sky-50 to-teal-50/80 py-16 text-slate-950 sm:py-18 lg:py-20">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_16%_18%,rgba(29,161,242,0.14),transparent_28%),radial-gradient(circle_at_88%_70%,rgba(45,212,191,0.13),transparent_30%)]"></div>
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-300/80 to-transparent"></div>
            <div class="container relative grid items-center gap-10 lg:grid-cols-[0.92fr_1.08fr] lg:gap-16">
                <div class="reveal relative">
                    <div class="absolute -left-5 -top-5 h-28 w-28 rounded-full bg-sky-200/70 blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-xl border border-sky-100 bg-white p-3 shadow-[0_24px_60px_rgba(8,35,68,0.14)]">
                        <img class="aspect-[4/5] w-full rounded-lg object-cover" src="https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=900&q=85" alt="Pharmacy student using microscope">
                    </div>
                    <div class="absolute -right-3 bottom-8 max-w-[178px] rounded-lg border border-sky-100 bg-white/95 p-5 text-center text-slate-950 shadow-[0_20px_45px_rgba(8,35,68,0.16)] sm:-right-8">
                        <strong class="block text-4xl font-black leading-none text-sky-500">15+</strong>
                        <span class="mt-2 block text-xs font-extrabold uppercase leading-5 tracking-wide text-slate-600">Years of academic focus</span>
                    </div>
                </div>

                <div class="reveal">
                    <span class="mb-4 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                        About SCPS
                    </span>
                    <h2 class="mb-5 max-w-2xl text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">A College Built for Serious Pharmacy Education</h2>
                    <p class="mb-7 max-w-2xl text-base leading-8 text-slate-600">Swat College of Pharmaceutical Sciences is designed around disciplined study, practical experimentation, and a clear professional pathway for students who want to serve healthcare through pharmacy.</p>

                    <div class="mb-8 grid gap-3 sm:grid-cols-1">
                        <div class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white/85 px-4 py-3 text-sm font-bold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:bg-white hover:shadow-[0_14px_32px_rgba(29,161,242,0.14)]">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-sky-500 text-white shadow-[0_10px_20px_rgba(29,161,242,0.25)]">✓</span>
                            Purpose-built teaching laboratories
                        </div>
                        <div class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white/85 px-4 py-3 text-sm font-bold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-300 hover:bg-white hover:shadow-[0_14px_32px_rgba(45,212,191,0.14)]">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-teal-400 text-slate-950 shadow-[0_10px_20px_rgba(45,212,191,0.22)]">✓</span>
                            Faculty-guided academic mentoring
                        </div>
                        <div class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white/85 px-4 py-3 text-sm font-bold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 hover:bg-white hover:shadow-[0_14px_32px_rgba(129,140,248,0.14)]">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-indigo-400 text-white shadow-[0_10px_20px_rgba(129,140,248,0.22)]">✓</span>
                            Professional ethics and patient care focus
                        </div>
                    </div>

                    <a href="#contact" class="inline-flex min-h-12 items-center justify-center rounded bg-sky-500 px-7 text-sm font-black uppercase tracking-wide !text-white shadow-[0_16px_32px_rgba(29,161,242,0.25)] transition hover:-translate-y-1 hover:bg-sky-400 hover:!text-white">Request Information</a>
                </div>
            </div>
        </section>

        <section id="stats" class="relative overflow-hidden bg-[#062b4f] py-10 text-white sm:py-12">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_14%_30%,rgba(29,161,242,0.32),transparent_28%),radial-gradient(circle_at_86%_12%,rgba(45,212,191,0.18),transparent_30%)]"></div>
            <div class="container relative grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="reveal rounded-lg border border-white/10 bg-white/[0.08] px-6 py-6 text-center shadow-[0_18px_45px_rgba(0,0,0,0.16)] backdrop-blur transition hover:-translate-y-1 hover:border-sky-300/60 hover:bg-white/[0.12]">
                    <strong class="block text-4xl font-black leading-none text-white sm:text-5xl" data-count="1200" data-count-suffix="+">0</strong>
                    <span class="mt-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-100/85">Students Trained</span>
                </div>
                <div class="reveal rounded-lg border border-white/10 bg-white/[0.08] px-6 py-6 text-center shadow-[0_18px_45px_rgba(0,0,0,0.16)] backdrop-blur transition hover:-translate-y-1 hover:border-teal-300/60 hover:bg-white/[0.12]">
                    <strong class="block text-4xl font-black leading-none text-white sm:text-5xl" data-count="42" data-count-suffix="+">0</strong>
                    <span class="mt-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-100/85">Faculty &amp; Staff</span>
                </div>
                <div class="reveal rounded-lg border border-white/10 bg-white/[0.08] px-6 py-6 text-center shadow-[0_18px_45px_rgba(0,0,0,0.16)] backdrop-blur transition hover:-translate-y-1 hover:border-indigo-300/60 hover:bg-white/[0.12]">
                    <strong class="block text-4xl font-black leading-none text-white sm:text-5xl" data-count="9">0</strong>
                    <span class="mt-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-100/85">Teaching Labs</span>
                </div>
                <div class="reveal rounded-lg border border-white/10 bg-white/[0.08] px-6 py-6 text-center shadow-[0_18px_45px_rgba(0,0,0,0.16)] backdrop-blur transition hover:-translate-y-1 hover:border-cyan-300/60 hover:bg-white/[0.12]">
                    <strong class="block text-4xl font-black leading-none text-white sm:text-5xl" data-count="18" data-count-suffix="+">0</strong>
                    <span class="mt-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-100/85">Academic Partners</span>
                </div>
            </div>
        </section>

        <section id="labs" class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-sky-50 to-transparent"></div>
            <div class="pointer-events-none absolute -right-24 top-28 h-72 w-72 rounded-full bg-sky-100/70 blur-3xl"></div>
            <div class="container relative">
                <div class="reveal mb-9 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <span class="mb-3 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                            <span class="h-0.5 w-9 bg-sky-500"></span>
                            Learning Experience
                        </span>
                        <h2 class="text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Featured Academic Facilities</h2>
                    </div>
                    <div class="flex gap-3">
                        <button class="grid h-12 w-12 place-items-center rounded-full border border-slate-200 bg-white text-3xl leading-none text-slate-950 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:bg-sky-500 hover:text-white hover:shadow-[0_14px_30px_rgba(29,161,242,0.20)]" type="button" data-card-prev aria-label="Previous facility">&lsaquo;</button>
                        <button class="grid h-12 w-12 place-items-center rounded-full border border-slate-200 bg-white text-3xl leading-none text-slate-950 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:bg-sky-500 hover:text-white hover:shadow-[0_14px_30px_rgba(29,161,242,0.20)]" type="button" data-card-next aria-label="Next facility">&rsaquo;</button>
                    </div>
                </div>
                <div class="-mx-5 flex snap-x gap-5 overflow-x-auto px-5 pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-card-carousel>
                    <article class="reveal group min-w-[285px] snap-start overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(8,35,68,0.10)] transition hover:-translate-y-1 hover:border-sky-200 hover:shadow-[0_26px_60px_rgba(29,161,242,0.16)] sm:min-w-[360px] lg:min-w-[390px]">
                        <div class="overflow-hidden">
                            <img class="h-60 w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1532187643603-ba119ca4109e?auto=format&fit=crop&w=900&q=85" alt="Chemistry laboratory equipment">
                        </div>
                        <div class="p-6">
                            <span class="mb-3 inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-sky-600">Laboratory</span>
                            <h3 class="mb-3 text-2xl font-black leading-snug text-slate-950">Pharmaceutical Chemistry Lab</h3>
                            <p class="text-base leading-7 text-slate-600">Analytical methods, compound behavior, and experimental discipline.</p>
                        </div>
                    </article>
                    <article class="reveal group min-w-[285px] snap-start overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(8,35,68,0.10)] transition hover:-translate-y-1 hover:border-teal-200 hover:shadow-[0_26px_60px_rgba(45,212,191,0.14)] sm:min-w-[360px] lg:min-w-[390px]">
                        <div class="overflow-hidden">
                            <img class="h-60 w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1614935151651-0bea6508db6b?auto=format&fit=crop&w=900&q=85" alt="Medicine manufacturing and capsules">
                        </div>
                        <div class="p-6">
                            <span class="mb-3 inline-flex rounded-full bg-teal-100 px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-teal-700">Practice</span>
                            <h3 class="mb-3 text-2xl font-black leading-snug text-slate-950">Pharmaceutics &amp; Formulation</h3>
                            <p class="text-base leading-7 text-slate-600">Dosage form design, stability, quality control, and production concepts.</p>
                        </div>
                    </article>
                    <article class="reveal group min-w-[285px] snap-start overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(8,35,68,0.10)] transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-[0_26px_60px_rgba(129,140,248,0.14)] sm:min-w-[360px] lg:min-w-[390px]">
                        <div class="overflow-hidden">
                            <img class="h-60 w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1579154341098-e4e158cc7f55?auto=format&fit=crop&w=900&q=85" alt="Clinical healthcare discussion">
                        </div>
                        <div class="p-6">
                            <span class="mb-3 inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-black uppercase tracking-[0.16em] text-indigo-700">Clinical</span>
                            <h3 class="mb-3 text-2xl font-black leading-snug text-slate-950">Patient Counseling Studio</h3>
                            <p class="text-base leading-7 text-slate-600">Communication, case review, medication safety, and ethical practice.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="faculty" class="relative overflow-hidden bg-gradient-to-b from-sky-50/70 via-white to-white py-14 sm:py-16 lg:py-20">
            <div class="pointer-events-none absolute -left-24 top-24 h-72 w-72 rounded-full bg-teal-100/70 blur-3xl"></div>
            <div class="container relative">
                <div class="reveal mx-auto mb-10 max-w-3xl text-center">
                    <span class="mb-3 inline-flex items-center justify-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                        Faculty
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                    </span>
                    <h2 class="text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Guided by Experienced Academic Mentors</h2>
                </div>

                <div class="faculty-preview-wrap">
                    <div class="grid gap-6 md:grid-cols-3">
                        @forelse($homeFaculty as $member)
                            <a href="{{ route('faculty.show', $member->slug) }}" class="faculty-accent faculty-accent--{{ $member->accent ?: 'sky' }} faculty-accent-card reveal group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(8,35,68,0.10)] transition hover:-translate-y-1">
                                <div class="relative overflow-hidden">
                                    <img class="h-80 w-full object-cover object-top transition duration-500 group-hover:scale-105" src="{{ $member->imageUrl() }}" alt="{{ $member->name }}">
                                    <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-slate-950/70 to-transparent"></div>
                                    <span class="faculty-accent-badge absolute bottom-4 left-4 rounded-full px-3 py-1 text-xs font-black uppercase tracking-[0.15em] text-white">{{ $member->department }}</span>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-2xl font-black text-slate-950">{{ $member->name }}</h3>
                                    <p class="mt-2 text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $member->designation }}</p>
                                    <span class="faculty-accent-link mt-5 inline-flex text-sm font-black uppercase tracking-wide">View Profile -&gt;</span>
                                </div>
                            </a>
                        @empty
                            <div class="faculty-empty reveal">
                                <span>Faculty Directory</span>
                                <h3>No faculty members are available right now.</h3>
                                <p>Faculty profiles will appear here as soon as they are added and published from the admin panel.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($homeFaculty->isNotEmpty())
                        <a href="{{ route('faculty.index') }}" class="faculty-more-link reveal" aria-label="View all faculty members">
                            <span class="faculty-more-link__text">View all faculty</span>
                            <span class="faculty-more-link__icon" aria-hidden="true">-&gt;</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section id="admissions" class="relative overflow-hidden bg-gradient-to-br from-white via-sky-50 to-cyan-50/70 py-14 text-slate-950 sm:py-16 lg:py-20">
            <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-sky-200/55 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-teal-100/80 blur-3xl"></div>
            <div class="container relative grid items-center gap-8 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="reveal">
                    <span class="mb-4 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                        Admissions
                    </span>
                    <h2 class="max-w-3xl text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Begin Your Pharmacy Journey at SCPS</h2>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">Applications are open for the next academic session. Visit campus, review eligibility, and speak with our admissions team.</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="#contact" class="inline-flex min-h-12 items-center justify-center rounded bg-sky-500 px-7 text-sm font-black uppercase tracking-wide !text-white shadow-[0_16px_32px_rgba(29,161,242,0.28)] transition hover:-translate-y-1 hover:bg-sky-400 hover:!text-white">Contact Admissions</a>
                        <a href="#programs" class="inline-flex min-h-12 items-center justify-center rounded border border-slate-200 bg-white px-7 text-sm font-black uppercase tracking-wide !text-slate-950 shadow-sm transition hover:-translate-y-1 hover:border-sky-300 hover:!text-sky-600 hover:shadow-[0_14px_30px_rgba(8,35,68,0.10)]">View Programs</a>
                    </div>
                </div>
                <div class="reveal rounded-2xl border border-white/15 bg-[#062b4f] p-5 text-white shadow-[0_28px_70px_rgba(8,35,68,0.22)] sm:p-6">
                    <div class="mb-5 rounded-xl bg-white/[0.08] p-5">
                        <span class="text-xs font-black uppercase tracking-[0.18em] text-sky-200">Admissions Desk</span>
                        <strong class="mt-2 block text-3xl font-black text-white">Open for 2026 Intake</strong>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                        <div class="rounded-lg border border-white/10 bg-white/[0.08] p-4">
                            <span class="text-xs font-black uppercase tracking-[0.18em] text-sky-200">Focus</span>
                            <strong class="mt-2 block text-xl font-black text-white">Pharmacy Practice</strong>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/[0.08] p-4">
                            <span class="text-xs font-black uppercase tracking-[0.18em] text-sky-200">Guidance</span>
                            <strong class="mt-2 block text-xl font-black text-white">Campus Visit</strong>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/[0.08] p-4">
                            <span class="text-xs font-black uppercase tracking-[0.18em] text-sky-200">Support</span>
                            <strong class="mt-2 block text-xl font-black text-white">Eligibility Help</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="events" class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-cyan-50/80 to-transparent"></div>
            <div class="container relative">
                <div class="reveal mb-9 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="mb-3 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                            <span class="h-0.5 w-9 bg-sky-500"></span>
                            Campus Calendar
                        </span>
                        <h2 class="text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Upcoming Events</h2>
                    </div>
                    <a href="{{ route('events.index') }}" class="inline-flex min-h-11 items-center justify-center rounded border border-slate-200 bg-white px-5 text-sm font-black uppercase tracking-wide !text-slate-950 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:!text-sky-600 hover:shadow-[0_14px_30px_rgba(8,35,68,0.10)]">View All Events</a>
                </div>
                <div class="grid gap-4">
                    @forelse($campusEvents as $event)
                        <article class="campus-event-accent campus-event-accent--{{ $event->accent ?: 'sky' }} reveal group grid gap-5 rounded-xl border border-slate-200 bg-white p-5 shadow-[0_16px_42px_rgba(8,35,68,0.08)] transition hover:-translate-y-1 sm:grid-cols-[96px_1fr_auto] sm:items-center">
                            <time class="campus-event-date grid h-24 w-24 place-items-center rounded-lg text-center text-white">
                                <span><strong class="block text-4xl font-black leading-none">{{ $event->starts_at->format('d') }}</strong><span class="mt-1 block text-xs font-black uppercase tracking-[0.2em]">{{ $event->starts_at->format('M') }}</span></span>
                            </time>
                            <div>
                                <h3 class="text-xl font-black leading-snug text-slate-950 sm:text-2xl">{{ $event->title }}</h3>
                                <p class="mt-2 text-base font-medium text-slate-600">{{ $event->venue ?: 'Venue pending' }} &middot; {{ $event->starts_at->format('h:i A') }}</p>
                                @if($event->description)
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">{{ $event->description }}</p>
                                @endif
                            </div>
                            <span class="campus-event-category hidden rounded-full px-4 py-2 text-xs font-black uppercase tracking-[0.16em] sm:inline-flex">{{ $event->category }}</span>
                        </article>
                    @empty
                        <div class="campus-events-empty reveal">
                            <span>Campus Calendar</span>
                            <h3>No upcoming events are available right now.</h3>
                            <p>Campus events will appear here after they are added and published from the admin panel.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-gradient-to-br from-white via-sky-50 to-cyan-50/70 py-10 text-slate-950 sm:py-12 lg:py-14" data-testimonial-slider>
            <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-sky-200/55 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-teal-100/80 blur-3xl"></div>
            <div class="container relative">
                <div class="reveal mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="mb-4 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                            <span class="h-0.5 w-9 bg-sky-500"></span>
                            Student Voice
                        </span>
                        <h2 class="max-w-3xl text-2xl font-extrabold leading-tight text-slate-950 sm:text-3xl lg:text-4xl">Stories From Our Pharmacy Students</h2>
                    </div>
                    <div class="flex gap-3">
                        <button class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-2xl leading-none text-slate-950 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:bg-sky-500 hover:text-white" type="button" data-testimonial-prev aria-label="Previous student voice">&lsaquo;</button>
                        <button class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-2xl leading-none text-slate-950 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-300 hover:bg-sky-500 hover:text-white" type="button" data-testimonial-next aria-label="Next student voice">&rsaquo;</button>
                    </div>
                </div>

                <div class="reveal relative rounded-2xl border border-white/15 bg-[#062b4f] p-5 text-white shadow-[0_24px_64px_rgba(8,35,68,0.22)] sm:p-6" data-testimonial-stage>
                    <article class="grid items-center gap-6 transition duration-500 ease-out opacity-100 translate-x-0 lg:grid-cols-[220px_1fr]" data-testimonial-slide>
                        <div class="relative mx-auto w-full max-w-[190px]">
                            <div class="absolute -left-4 -top-4 h-20 w-20 rounded-full bg-sky-400/20 blur-2xl"></div>
                            <img class="relative aspect-square w-full rounded-xl object-cover shadow-[0_18px_38px_rgba(0,0,0,0.24)]" src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=700&q=85" alt="Student portrait">
                            <div class="mt-4 text-center">
                                <strong class="block text-lg font-black text-white">Ayesha Karim</strong>
                                <span class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-sky-200">Final Year Student</span>
                            </div>
                        </div>
                        <div>
                            <blockquote class="relative max-w-4xl text-xl font-extrabold leading-snug text-white sm:text-2xl lg:text-3xl">
                                <span class="absolute -left-2 -top-6 text-5xl font-black leading-none text-sky-300/30 sm:-left-5">&ldquo;</span>
                                SCPS gives pharmacy students a serious academic environment and practical exposure. The laboratory work makes the science feel real, not just theoretical.
                            </blockquote>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Practical</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">lab exposure</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Focused</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">academic culture</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Guided</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">student support</span></div>
                            </div>
                        </div>
                    </article>

                    <article class="absolute inset-0 grid items-center gap-6 transition duration-500 ease-out opacity-0 translate-x-6 pointer-events-none lg:grid-cols-[220px_1fr]" data-testimonial-slide>
                        <div class="relative mx-auto w-full max-w-[190px]">
                            <div class="absolute -left-4 -top-4 h-20 w-20 rounded-full bg-teal-400/20 blur-2xl"></div>
                            <img class="relative aspect-square w-full rounded-xl object-cover shadow-[0_18px_38px_rgba(0,0,0,0.24)]" src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=85" alt="Student portrait">
                            <div class="mt-4 text-center">
                                <strong class="block text-lg font-black text-white">Hamza Ali</strong>
                                <span class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-teal-200">Pharmaceutics Student</span>
                            </div>
                        </div>
                        <div>
                            <blockquote class="relative max-w-4xl text-xl font-extrabold leading-snug text-white sm:text-2xl lg:text-3xl">
                                <span class="absolute -left-2 -top-6 text-5xl font-black leading-none text-teal-300/30 sm:-left-5">&ldquo;</span>
                                The faculty explain difficult pharmacy concepts with patience, and the practical sessions help me connect formulation work with real healthcare needs.
                            </blockquote>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Clear</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">teaching style</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Hands-on</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">formulation work</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Relevant</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">healthcare focus</span></div>
                            </div>
                        </div>
                    </article>

                    <article class="absolute inset-0 grid items-center gap-6 transition duration-500 ease-out opacity-0 translate-x-6 pointer-events-none lg:grid-cols-[220px_1fr]" data-testimonial-slide>
                        <div class="relative mx-auto w-full max-w-[190px]">
                            <div class="absolute -left-4 -top-4 h-20 w-20 rounded-full bg-indigo-400/20 blur-2xl"></div>
                            <img class="relative aspect-square w-full rounded-xl object-cover shadow-[0_18px_38px_rgba(0,0,0,0.24)]" src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=700&q=85" alt="Student portrait">
                            <div class="mt-4 text-center">
                                <strong class="block text-lg font-black text-white">Maha Noor</strong>
                                <span class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-indigo-200">Clinical Pharmacy Student</span>
                            </div>
                        </div>
                        <div>
                            <blockquote class="relative max-w-4xl text-xl font-extrabold leading-snug text-white sm:text-2xl lg:text-3xl">
                                <span class="absolute -left-2 -top-6 text-5xl font-black leading-none text-indigo-300/30 sm:-left-5">&ldquo;</span>
                                I like how the college keeps discipline and mentoring together. It feels structured, but there is always guidance when you need support.
                            </blockquote>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Mentored</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">academic path</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Organized</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">study rhythm</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Supportive</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">faculty access</span></div>
                            </div>
                        </div>
                    </article>

                    <article class="absolute inset-0 grid items-center gap-6 transition duration-500 ease-out opacity-0 translate-x-6 pointer-events-none lg:grid-cols-[220px_1fr]" data-testimonial-slide>
                        <div class="relative mx-auto w-full max-w-[190px]">
                            <div class="absolute -left-4 -top-4 h-20 w-20 rounded-full bg-cyan-400/20 blur-2xl"></div>
                            <img class="relative aspect-square w-full rounded-xl object-cover shadow-[0_18px_38px_rgba(0,0,0,0.24)]" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=700&q=85" alt="Student portrait">
                            <div class="mt-4 text-center">
                                <strong class="block text-lg font-black text-white">Bilal Khan</strong>
                                <span class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-cyan-200">Pharmacology Student</span>
                            </div>
                        </div>
                        <div>
                            <blockquote class="relative max-w-4xl text-xl font-extrabold leading-snug text-white sm:text-2xl lg:text-3xl">
                                <span class="absolute -left-2 -top-6 text-5xl font-black leading-none text-cyan-300/30 sm:-left-5">&ldquo;</span>
                                The learning environment pushes us to be professional. Seminars, labs, and regular feedback make the pharmacy journey feel purposeful.
                            </blockquote>
                            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Professional</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">learning habits</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Active</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">campus events</span></div>
                                <div class="rounded-lg border border-white/10 bg-white/[0.08] p-3 backdrop-blur"><strong class="block text-lg font-black text-white">Purposeful</strong><span class="mt-1 block text-xs font-medium text-sky-100/80">career direction</span></div>
                            </div>
                        </div>
                    </article>
                </div>

                <div class="mt-6 flex justify-center gap-3" aria-label="Student voice slides">
                    <button class="h-2.5 w-8 rounded-full bg-sky-400 transition" type="button" data-testimonial-dot aria-label="Show student voice 1" aria-selected="true"></button>
                    <button class="h-2.5 w-2.5 rounded-full bg-slate-300 transition hover:bg-sky-300" type="button" data-testimonial-dot aria-label="Show student voice 2" aria-selected="false"></button>
                    <button class="h-2.5 w-2.5 rounded-full bg-slate-300 transition hover:bg-sky-300" type="button" data-testimonial-dot aria-label="Show student voice 3" aria-selected="false"></button>
                    <button class="h-2.5 w-2.5 rounded-full bg-slate-300 transition hover:bg-sky-300" type="button" data-testimonial-dot aria-label="Show student voice 4" aria-selected="false"></button>
                </div>
            </div>
        </section>


        <section id="news" class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-sky-50/90 to-transparent"></div>
            <div class="container relative">
                <div class="reveal mx-auto mb-10 max-w-3xl text-center">
                    <span class="mb-3 inline-flex items-center justify-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-sky-500">
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                        News Update
                        <span class="h-0.5 w-9 bg-sky-500"></span>
                    </span>
                    <h2 class="text-3xl font-extrabold leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Latest From SCPS</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @forelse($newsPosts as $post)
                        <article class="campus-event-accent campus-event-accent--{{ $post->accent ?: 'sky' }} reveal group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(8,35,68,0.10)] transition hover:-translate-y-1 hover:shadow-[0_26px_60px_rgba(29,161,242,0.15)]">
                            <div class="overflow-hidden">
                                <img class="h-56 w-full object-cover transition duration-500 group-hover:scale-105" src="{{ $post->imageUrl() }}" alt="{{ $post->image_alt ?: $post->title }}">
                            </div>
                            <div class="p-6">
                                <span class="campus-event-category mb-3 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase tracking-[0.14em]">{{ optional($post->published_at)->format('M d, Y') ?: $post->category }}</span>
                                <h3 class="mb-3 text-xl font-black leading-snug text-slate-950">{{ $post->title }}</h3>
                                @if($post->excerpt)
                                    <p class="mb-5 text-sm leading-6 text-slate-500">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('news.show', $post->slug) }}" class="campus-event-link inline-flex items-center text-sm font-black uppercase tracking-wide transition hover:translate-x-1">Read More</a>
                            </div>
                        </article>
                    @empty
                        <div class="campus-events-empty reveal md:col-span-3">
                            <span>News Update</span>
                            <h3>No news posts are available right now.</h3>
                            <p>Latest announcements will appear here after they are added and published from the admin panel.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('partials.site-footer')
</body>
</html>

