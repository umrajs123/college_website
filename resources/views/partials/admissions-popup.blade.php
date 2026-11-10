@if($settings->admissions_popup_is_active)
    @php
        $popupButtonUrl = $settings->admissions_popup_button_url
            ?: ($admissionsUrl ?? $settings->admissions_url ?: 'https://scps.digitalcampuspro.com/admin/login');
        $popupImageUrl = $settings->admissionsPopupImageUrl();
    @endphp

    <div class="admissions-popup" data-admissions-popup hidden>
        <button class="admissions-popup__backdrop" type="button" data-admissions-popup-close aria-label="Close admissions announcement"></button>
        <section
            class="admissions-popup__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="admissionsPopupHeading"
            aria-describedby="admissionsPopupBody"
            tabindex="-1"
        >
            <button class="admissions-popup__close" type="button" data-admissions-popup-close aria-label="Close popup">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"></path></svg>
            </button>

            <div class="admissions-popup__content">
                <div class="admissions-popup__topline">
                    <div class="admissions-popup__brand">
                        <span class="admissions-popup__brand-logo">
                            <img src="{{ $settings->logoUrl() }}" alt="{{ $settings->site_name }} logo">
                        </span>
                        <span class="admissions-popup__brand-copy">
                            <strong>{{ $settings->site_name }}</strong>
                            <small>{{ $settings->site_tagline }}</small>
                        </span>
                    </div>
                </div>
                <h2 id="admissionsPopupHeading">{{ $settings->admissions_popup_heading }}</h2>
                <p class="admissions-popup__body" id="admissionsPopupBody">{{ $settings->admissions_popup_body }}</p>
                <a class="admissions-popup__apply" href="{{ $popupButtonUrl }}">
                    {{ $settings->admissions_popup_button_label }}
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <button class="admissions-popup__dismiss" type="button" data-admissions-popup-close>Maybe later</button>
            </div>

            <div class="admissions-popup__art">
                @if($popupImageUrl)
                    <img class="admissions-popup__background" src="{{ $popupImageUrl }}" alt="">
                @endif
                <div class="admissions-popup__art-orbit admissions-popup__art-orbit--one" aria-hidden="true"></div>
                <div class="admissions-popup__art-orbit admissions-popup__art-orbit--two" aria-hidden="true"></div>
                <div class="admissions-popup__capsule" aria-hidden="true">
                    <span></span><i></i>
                </div>
                <div class="admissions-popup__art-info">
                    <span class="admissions-popup__eyebrow" role="status">
                        <span aria-hidden="true"></span>
                        <span>
                            <strong>{{ $settings->admissions_popup_eyebrow ?: 'Admissions Open' }}</strong>
                            <small>{{ $settings->admissions_popup_session }}</small>
                        </span>
                    </span>
                    @if(($admissionsPopupPrograms ?? collect())->isNotEmpty())
                        <section class="admissions-popup__programs" aria-labelledby="admissionsPopupProgramsHeading">
                            <h3 id="admissionsPopupProgramsHeading">Programs open for admission</h3>
                            <div class="admissions-popup__program-list">
                                @foreach($admissionsPopupPrograms as $program)
                                    <a class="admissions-popup__program" href="{{ $program->publicUrl() }}">
                                        <span>{{ $program->icon_label ?: 'Rx' }}</span>
                                        <strong>{{ $program->title }}</strong>
                                        <i aria-hidden="true">&rarr;</i>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                    <div class="admissions-popup__art-copy">
                        <span class="admissions-popup__art-line" aria-hidden="true"></span>
                        <strong>A future<br>in healthcare.</strong>
                        <small>Knowledge that makes a difference</small>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        (() => {
            const popup = document.querySelector('[data-admissions-popup]');
            if (!popup) return;

            const dialog = popup.querySelector('[role="dialog"]');
            const closeButtons = popup.querySelectorAll('[data-admissions-popup-close]');
            const previouslyFocused = document.activeElement;
            const dismiss = () => {
                popup.hidden = true;
                document.body.classList.remove('admissions-popup-open');
                previouslyFocused?.focus?.();
            };

            popup.hidden = false;
            document.body.classList.add('admissions-popup-open');
            dialog.focus();

            closeButtons.forEach((button) => button.addEventListener('click', dismiss));
            document.addEventListener('keydown', (event) => {
                if (popup.hidden) return;

                if (event.key === 'Escape') {
                    dismiss();
                    return;
                }

                if (event.key !== 'Tab') return;

                const focusable = [...popup.querySelectorAll('a[href], button:not(:disabled)')];
                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (event.shiftKey && (document.activeElement === first || document.activeElement === dialog)) {
                    event.preventDefault();
                    last.focus();
                } else if (! event.shiftKey && (document.activeElement === last || document.activeElement === dialog)) {
                    event.preventDefault();
                    first.focus();
                }
            });
        })();
    </script>
@endif
