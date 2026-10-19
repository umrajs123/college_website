@php
    $homeUrl = url('/');
    $settings = $siteSettings ?? \App\Models\SiteSetting::current();
    $admissionsUrl = $settings->admissions_url ?: 'https://scps.digitalcampuspro.com/admin/login';
@endphp

<footer id="contact" class="relative overflow-hidden bg-[#071a2e] text-white">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_14%_16%,rgba(29,161,242,0.20),transparent_28%),radial-gradient(circle_at_88%_76%,rgba(45,212,191,0.12),transparent_30%)]"></div>
    <div class="container relative grid gap-10 py-12 sm:py-14 lg:grid-cols-[1.35fr_0.75fr_0.75fr_1fr] lg:gap-12">
        <div>
            <a href="{{ $homeUrl }}" class="inline-flex items-center gap-4 !text-white">
                <span class="grid h-20 w-20 shrink-0 place-items-center rounded-full bg-white p-1 shadow-[0_18px_38px_rgba(0,0,0,0.25)]">
                    <img class="h-full w-full rounded-full object-contain" src="{{ $settings->logoUrl() }}" alt="{{ $settings->site_name }} logo">
                </span>
                <span>
                    <strong class="block text-2xl font-black leading-tight">{{ $settings->site_name }}</strong>
                    <small class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-sky-200">{{ $settings->site_tagline }}</small>
                </span>
            </a>
            <p class="mt-6 max-w-md text-base leading-8 text-sky-50/78">{{ $settings->site_description }}</p>
            <div class="mt-6 flex gap-3">
                @if($settings->facebook_url)
                    <a href="{{ $settings->facebook_url }}" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="Facebook">f</a>
                @endif
                @if($settings->linkedin_url)
                    <a href="{{ $settings->linkedin_url }}" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="LinkedIn">in</a>
                @endif
                @if($settings->youtube_url)
                    <a href="{{ $settings->youtube_url }}" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="YouTube">YT</a>
                @endif
            </div>
        </div>
        <div>
            <h3 class="mb-5 text-lg font-black text-white">Quick Links</h3>
            <div class="grid gap-3 text-sm font-bold">
                <a href="{{ $homeUrl }}#about" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">About</a>
                <a href="{{ $homeUrl }}#programs" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Programs</a>
                <a href="{{ route('faculty.index') }}" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Faculty</a>
                <a href="{{ $homeUrl }}#events" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Events</a>
            </div>
        </div>
        <div>
            <h3 class="mb-5 text-lg font-black text-white">Admissions</h3>
            <div class="grid gap-3 text-sm font-bold">
                <a href="{{ $admissionsUrl }}" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Apply Now</a>
                <a href="{{ $admissionsUrl }}" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Fee Information</a>
                <a href="{{ $admissionsUrl }}" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Prospectus</a>
                <a href="{{ $admissionsUrl }}" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Scholarships</a>
            </div>
        </div>
        <div>
            <h3 class="mb-5 text-lg font-black text-white">Contact</h3>
            <p class="mb-4 text-sm font-medium leading-7 text-sky-50/78">{{ $settings->address }}</p>
            <div class="grid gap-3 text-sm font-bold">
                @if($settings->phone)
                    <a href="{{ $settings->phoneHref() }}" class="!text-sky-50/78 transition hover:!text-sky-300">{{ $settings->phone }}</a>
                @endif
                @if($settings->email)
                    <a href="{{ $settings->emailHref() }}" class="!text-sky-50/78 transition hover:!text-sky-300">{{ $settings->email }}</a>
                @endif
            </div>
            <form class="mt-6 flex overflow-hidden rounded-lg border border-white/10 bg-white/[0.08] p-1">
                <input class="min-w-0 flex-1 bg-transparent px-4 py-3 text-sm font-semibold text-white outline-none placeholder:text-sky-100/50" type="email" placeholder="Email address" aria-label="Email address">
                <button class="rounded-md bg-sky-500 px-5 text-sm font-black uppercase tracking-wide text-white transition hover:bg-sky-400" type="submit">Join</button>
            </form>
        </div>
    </div>
    <div class="container relative flex flex-col gap-3 border-t border-white/10 py-5 text-sm font-semibold text-sky-50/65 sm:flex-row sm:items-center sm:justify-between">
        <span>&copy; {{ now()->year }} {{ $settings->site_name }} {{ $settings->site_tagline }}.</span>
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
            <a href="#developerContactModal" class="developer-contact-trigger !text-sky-50/65 transition hover:!text-sky-300" aria-haspopup="dialog" aria-controls="developerContactModal">Contact the developer?</a>
            <!-- <a href="{{ $settings->privacy_url ?: '#' }}" class="!text-sky-50/65 transition hover:!text-sky-300">Privacy Policy</a> -->
        </div>
    </div>
</footer>

<dialog id="developerContactModal" class="developer-contact-modal" aria-labelledby="developerContactTitle" aria-describedby="developerContactDescription">
    <div class="developer-contact-card">
        <button class="developer-contact-close" type="button" aria-label="Close contact details" data-close-developer-contact>&times;</button>
        <div class="developer-contact-avatar" aria-hidden="true">
            <img src="{{ asset('images/adnan-umraj.webp') }}" alt="">
        </div>
        <!-- <p class="developer-contact-eyebrow">Your next college website starts here</p> -->
        <h2 id="developerContactTitle">Adnan K Umraj</h2>
        <p id="developerContactDescription" class="developer-contact-intro">Have a project in mind? Get in touch and let’s build something great for you!</p>
        <div class="developer-contact-links">
            <a href="mailto:umrajs123@gmail.com" class="developer-contact-link">
                <span class="developer-contact-icon" aria-hidden="true">@</span>
                <span><small>Email</small><strong>umrajs123@gmail.com</strong></span>
                <span class="developer-contact-arrow" aria-hidden="true">&nearr;</span>
            </a>
            <a href="https://wa.me/923433946559" class="developer-contact-link" target="_blank" rel="noopener noreferrer">
                <span class="developer-contact-icon developer-contact-icon--whatsapp" aria-hidden="true">WA</span>
                <span><small>WhatsApp</small><strong>+92 343 3946559</strong></span>
                <span class="developer-contact-arrow" aria-hidden="true">&nearr;</span>
            </a>
            <a href="https://github.com/umrajs123" class="developer-contact-link" target="_blank" rel="noopener noreferrer">
                <span class="developer-contact-icon developer-contact-icon--github" aria-hidden="true">GH</span>
                <span><small>GitHub</small><strong>github.com/umrajs123</strong></span>
                <span class="developer-contact-arrow" aria-hidden="true">&nearr;</span>
            </a>
        </div>
        <!-- <p class="developer-contact-note">College website projects welcome</p> -->
    </div>
</dialog>

<button class="back-to-top" type="button" aria-label="Back to top">&uarr;</button>

<script src="{{ asset('js/scps.js') }}?v={{ filemtime(public_path('js/scps.js')) }}"></script>
