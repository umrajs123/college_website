@php
    $homeUrl = url('/');
@endphp

<footer id="contact" class="relative overflow-hidden bg-[#071a2e] text-white">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_14%_16%,rgba(29,161,242,0.20),transparent_28%),radial-gradient(circle_at_88%_76%,rgba(45,212,191,0.12),transparent_30%)]"></div>
    <div class="container relative grid gap-10 py-12 sm:py-14 lg:grid-cols-[1.35fr_0.75fr_0.75fr_1fr] lg:gap-12">
        <div>
            <a href="{{ $homeUrl }}" class="inline-flex items-center gap-4 !text-white">
                <span class="grid h-20 w-20 shrink-0 place-items-center rounded-full bg-white p-1 shadow-[0_18px_38px_rgba(0,0,0,0.25)]">
                    <img class="h-full w-full rounded-full object-contain" src="{{ asset('images/scps-logo.png') }}" alt="Swat College of Pharmaceutical Sciences logo">
                </span>
                <span>
                    <strong class="block text-2xl font-black leading-tight">Swat College</strong>
                    <small class="mt-1 block text-xs font-black uppercase tracking-[0.18em] text-sky-200">of Pharmaceutical Sciences</small>
                </span>
            </a>
            <p class="mt-6 max-w-md text-base leading-8 text-sky-50/78">Academic pharmacy education in Swat with a focus on professional competence, laboratory skill, and healthcare service.</p>
            <div class="mt-6 flex gap-3">
                <a href="#" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="Facebook">f</a>
                <a href="#" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="LinkedIn">in</a>
                <a href="#" class="grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/[0.08] text-sm font-black !text-white transition hover:-translate-y-0.5 hover:bg-sky-500 hover:!text-white" aria-label="YouTube">YT</a>
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
                <a href="{{ $homeUrl }}#admissions" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Apply Now</a>
                <a href="{{ $homeUrl }}#contact" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Fee Information</a>
                <a href="{{ $homeUrl }}#contact" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Prospectus</a>
                <a href="{{ $homeUrl }}#contact" class="!text-sky-50/78 transition hover:translate-x-1 hover:!text-sky-300">Scholarships</a>
            </div>
        </div>
        <div>
            <h3 class="mb-5 text-lg font-black text-white">Contact</h3>
            <p class="mb-4 text-sm font-medium leading-7 text-sky-50/78">College Road, Swat, Khyber Pakhtunkhwa, Pakistan</p>
            <div class="grid gap-3 text-sm font-bold">
                <a href="tel:+92946123456" class="!text-sky-50/78 transition hover:!text-sky-300">+92 946 123456</a>
                <a href="mailto:info@scps.edu.pk" class="!text-sky-50/78 transition hover:!text-sky-300">info@scps.edu.pk</a>
            </div>
            <form class="mt-6 flex overflow-hidden rounded-lg border border-white/10 bg-white/[0.08] p-1">
                <input class="min-w-0 flex-1 bg-transparent px-4 py-3 text-sm font-semibold text-white outline-none placeholder:text-sky-100/50" type="email" placeholder="Email address" aria-label="Email address">
                <button class="rounded-md bg-sky-500 px-5 text-sm font-black uppercase tracking-wide text-white transition hover:bg-sky-400" type="submit">Join</button>
            </form>
        </div>
    </div>
    <div class="container relative flex flex-col gap-3 border-t border-white/10 py-5 text-sm font-semibold text-sky-50/65 sm:flex-row sm:items-center sm:justify-between">
        <span>&copy; 2026 Swat College of Pharmaceutical Sciences.</span>
        <a href="#" class="!text-sky-50/65 transition hover:!text-sky-300">Privacy Policy</a>
    </div>
</footer>

<button class="back-to-top" type="button" aria-label="Back to top">&uarr;</button>

<script src="{{ asset('js/scps.js') }}?v={{ filemtime(public_path('js/scps.js')) }}"></script>
