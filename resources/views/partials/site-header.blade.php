@php
    $homeUrl = url('/');
    $isHome = request()->is('/');
    $isNews = request()->routeIs('news.*');
    $isFaculty = request()->routeIs('faculty.*');
    $isEvents = request()->routeIs('events.*');
    $isPrograms = $isFaculty || $isEvents;
@endphp

<div class="preloader" aria-hidden="true">
    <div class="preloader__mark">SCPS</div>
</div>

<header id="siteHeader" class="scps-tailwind-header fixed inset-x-0 top-0 z-50 transition-all duration-300">
    <nav aria-label="Primary navigation">
        <div class="container flex min-h-[92px] items-center justify-between gap-5">
            <a href="{{ $homeUrl }}" class="flex min-w-0 items-center gap-3 !text-slate-950" aria-label="Swat College of Pharmaceutical Sciences home">
                <span class="grid h-16 w-16 shrink-0 place-items-center rounded-full bg-white p-1 shadow-[0_12px_30px_rgba(8,35,68,0.14)]">
                    <img class="h-full w-full rounded-full object-contain" src="{{ asset('images/scps-logo.png') }}" alt="Swat College of Pharmaceutical Sciences logo">
                </span>
                <span class="min-w-0">
                    <strong class="block truncate text-2xl font-black leading-tight text-[#062b4f]">Swat College</strong>
                    <small class="block truncate text-xs font-black uppercase tracking-[0.12em] text-slate-500">of Pharmaceutical Sciences</small>
                </span>
            </a>

            <button class="nav-toggle" type="button" aria-label="Open menu" aria-controls="mobileMenu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="scps-header-menu hidden items-center gap-8 lg:flex">
                <li>
                    <a href="{{ $homeUrl }}" class="relative inline-flex items-center gap-2 py-8 text-sm font-black uppercase tracking-wide transition hover:!text-sky-500 {{ $isHome ? 'is-active !text-sky-500' : '' }}">
                        Home <span>+</span>
                        <span class="absolute inset-x-0 bottom-6 h-0.5 bg-sky-500 transition {{ $isHome ? 'scale-x-100' : 'scale-x-0' }}"></span>
                    </a>
                </li>
                <li class="group relative">
                    <a href="{{ $homeUrl }}#about" class="relative inline-flex items-center gap-2 py-8 text-sm font-black uppercase tracking-wide transition hover:!text-sky-500 group-hover:!text-sky-500">
                        About
                        <span class="transition group-hover:hidden">+</span>
                        <span class="hidden text-sky-500 group-hover:inline">-</span>
                        <span class="absolute inset-x-0 bottom-6 h-0.5 scale-x-0 bg-sky-500 transition group-hover:scale-x-100"></span>
                    </a>
                    <div class="invisible absolute left-0 top-full w-64 translate-y-3 rounded-b-lg border-t-2 border-sky-500 bg-white p-3 opacity-0 shadow-[0_24px_60px_rgba(8,35,68,0.16)] transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        <a href="{{ $homeUrl }}#about" class="block rounded px-4 py-3 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">College Overview</a>
                        <a href="{{ $homeUrl }}#stats" class="block rounded px-4 py-3 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Mission & Recognition</a>
                        <a href="{{ $homeUrl }}#campus" class="block rounded px-4 py-3 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Campus Life</a>
                    </div>
                </li>
                <li class="group relative">
                    <a href="{{ $homeUrl }}#programs" class="relative inline-flex items-center gap-2 py-8 text-sm font-black uppercase tracking-wide transition hover:!text-sky-500 group-hover:!text-sky-500 {{ $isPrograms ? 'is-active !text-sky-500' : '' }}">
                        Programs
                        <span class="transition {{ $isPrograms ? 'hidden' : 'group-hover:hidden' }}">+</span>
                        <span class="{{ $isPrograms ? 'inline' : 'hidden group-hover:inline' }} text-sky-500">-</span>
                        <span class="absolute inset-x-0 bottom-6 h-0.5 bg-sky-500 transition group-hover:scale-x-100 {{ $isPrograms ? 'scale-x-100' : 'scale-x-0' }}"></span>
                    </a>
                    <div class="invisible absolute left-1/2 top-full w-[640px] -translate-x-1/2 translate-y-3 rounded-b-lg border-t-2 border-sky-500 bg-white p-6 opacity-0 shadow-[0_24px_60px_rgba(8,35,68,0.16)] transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        <div class="grid grid-cols-[1fr_1fr_1.15fr] gap-6">
                            <div>
                                <span class="mb-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-500">Academics</span>
                                <a href="{{ $homeUrl }}#programs" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Doctor of Pharmacy</a>
                                <a href="{{ $homeUrl }}#programs" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Pharmaceutics</a>
                                <a href="{{ $homeUrl }}#programs" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Clinical Pharmacy</a>
                            </div>
                            <div>
                                <span class="mb-3 block text-xs font-black uppercase tracking-[0.18em] text-sky-500">Learning</span>
                                <a href="{{ $homeUrl }}#labs" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Research Labs</a>
                                <a href="{{ route('faculty.index') }}" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Faculty Mentorship</a>
                                <a href="{{ route('events.index') }}" class="block rounded px-3 py-2 text-sm font-bold !text-slate-700 transition hover:bg-sky-50 hover:!text-sky-600">Seminars</a>
                            </div>
                            <div class="rounded-lg bg-[#062b4f] p-5 text-white">
                                <strong class="block text-lg font-black">Modern pharmacy education</strong>
                                <p class="mt-3 text-sm leading-6 text-sky-50/80">Classroom learning, laboratory practice, and clinical exposure in one focused pathway.</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('news.index') }}" class="relative inline-flex items-center gap-2 py-8 text-sm font-black uppercase tracking-wide transition hover:!text-sky-500 {{ $isNews ? 'is-active !text-sky-500' : '' }}">
                        News <span>{{ $isNews ? '-' : '+' }}</span>
                        <span class="absolute inset-x-0 bottom-6 h-0.5 bg-sky-500 transition {{ $isNews ? 'scale-x-100' : 'scale-x-0' }}"></span>
                    </a>
                </li>
                <li><a href="{{ $homeUrl }}#contact" class="relative inline-flex items-center gap-2 py-8 text-sm font-black uppercase tracking-wide transition hover:!text-sky-500">Contact <span>+</span></a></li>
            </ul>

            <div class="hidden items-center gap-4 lg:flex">
                <button class="grid h-14 w-14 place-items-center rounded-full bg-sky-50 text-2xl text-[#062b4f] transition hover:bg-sky-500 hover:text-white" type="button" data-open-search aria-label="Search site">
                    <span>Q</span>
                </button>
                <a href="{{ $homeUrl }}#admissions" class="inline-flex min-h-14 items-center justify-center rounded bg-sky-500 px-7 text-sm font-black uppercase tracking-wide !text-white shadow-[0_16px_32px_rgba(29,161,242,0.24)] transition hover:-translate-y-0.5 hover:bg-sky-400 hover:!text-white">Apply Now</a>
            </div>
        </div>
    </nav>
</header>

<aside class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <div class="mobile-menu__panel">
        <div class="mobile-menu__head">
            <a href="{{ $homeUrl }}" class="brand">
                <span class="brand__seal">
                    <img src="{{ asset('images/scps-logo.png') }}" alt="Swat College of Pharmaceutical Sciences logo">
                </span>
                <span>
                    <strong>SCPS</strong>
                    <small>Pharmaceutical Sciences</small>
                </span>
            </a>
            <button class="mobile-close" type="button" aria-label="Close menu">x</button>
        </div>
        <a href="{{ $homeUrl }}" class="{{ $isHome ? 'mobile-active' : '' }}">Home</a>
        <a href="{{ $homeUrl }}#about">About</a>
        <a href="{{ $homeUrl }}#programs" class="{{ $isPrograms ? 'mobile-active' : '' }}">Programs</a>
        <a href="{{ route('faculty.index') }}" class="{{ $isFaculty ? 'mobile-active' : '' }}">Faculty</a>
        <a href="{{ route('events.index') }}" class="{{ $isEvents ? 'mobile-active' : '' }}">Events</a>
        <a href="{{ route('news.index') }}" class="{{ $isNews ? 'mobile-active' : '' }}">News</a>
        <a href="{{ $homeUrl }}#contact">Contact</a>
        <a href="{{ $homeUrl }}#admissions" class="btn btn--primary">Apply Now</a>
    </div>
</aside>

<div class="search-modal" aria-hidden="true">
    <button class="search-modal__close" type="button" aria-label="Close search">x</button>
    <form class="search-modal__box">
        <label for="siteSearch">Search SCPS</label>
        <div>
            <input id="siteSearch" type="search" placeholder="Search programs, admissions, faculty...">
            <button type="submit">Search</button>
        </div>
    </form>
</div>
