const body = document.body;
const header = document.querySelector('#siteHeader');
const preloader = document.querySelector('.preloader');
const mobileMenu = document.querySelector('#mobileMenu');
const navToggle = document.querySelector('.nav-toggle');
const mobileClose = document.querySelector('.mobile-close');
const searchModal = document.querySelector('.search-modal');
const searchOpen = document.querySelector('[data-open-search]');
const searchClose = document.querySelector('.search-modal__close');
const developerContactModal = document.querySelector('#developerContactModal');
const developerContactTrigger = document.querySelector('[aria-controls="developerContactModal"]');
const backToTop = document.querySelector('.back-to-top');

window.addEventListener('load', () => {
    window.setTimeout(() => preloader?.classList.add('done'), 450);
});

const setHeaderState = () => {
    const sticky = window.scrollY > 28;
    header?.classList.toggle('is-sticky', sticky);
    backToTop?.classList.toggle('is-visible', window.scrollY > 520);
};

window.addEventListener('scroll', setHeaderState, { passive: true });
setHeaderState();

const openMenu = () => {
    mobileMenu?.classList.add('is-open');
    navToggle?.classList.add('is-open');
    navToggle?.setAttribute('aria-expanded', 'true');
    mobileMenu?.setAttribute('aria-hidden', 'false');
    body.classList.add('menu-open');
};

const closeMenu = () => {
    mobileMenu?.classList.remove('is-open');
    navToggle?.classList.remove('is-open');
    navToggle?.setAttribute('aria-expanded', 'false');
    mobileMenu?.setAttribute('aria-hidden', 'true');
    body.classList.remove('menu-open');
};

navToggle?.addEventListener('click', () => {
    mobileMenu?.classList.contains('is-open') ? closeMenu() : openMenu();
});

mobileClose?.addEventListener('click', closeMenu);
mobileMenu?.addEventListener('click', (event) => {
    if (event.target === mobileMenu || event.target.matches('.mobile-menu__panel a')) {
        closeMenu();
    }
});

const openSearch = () => {
    searchModal?.classList.add('is-open');
    searchModal?.setAttribute('aria-hidden', 'false');
    body.classList.add('search-open');
    window.setTimeout(() => document.querySelector('#siteSearch')?.focus(), 120);
};

const closeSearch = () => {
    searchModal?.classList.remove('is-open');
    searchModal?.setAttribute('aria-hidden', 'true');
    body.classList.remove('search-open');
};

searchOpen?.addEventListener('click', openSearch);
searchClose?.addEventListener('click', closeSearch);
searchModal?.addEventListener('click', (event) => {
    if (event.target === searchModal) closeSearch();
});

developerContactTrigger?.addEventListener('click', (event) => {
    event.preventDefault();
    developerContactModal?.showModal();
    developerContactModal?.querySelector('[data-close-developer-contact]')?.focus();
});

developerContactModal?.querySelector('[data-close-developer-contact]')?.addEventListener('click', () => {
    developerContactModal.close();
});

developerContactModal?.addEventListener('click', (event) => {
    if (event.target === developerContactModal) developerContactModal.close();
});

developerContactModal?.addEventListener('close', () => developerContactTrigger?.focus());

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeMenu();
        closeSearch();
        if (developerContactModal?.open) developerContactModal.close();
    }
});

const slides = [...document.querySelectorAll('[data-hero-slide]')];
const heroSlider = document.querySelector('[data-slider]');
const dotsWrap = document.querySelector('[data-dots]');
let activeSlide = 0;
let heroTimer;
let heroPaused = false;
let heroTypingTimer;

const prepareHeroHeading = (slide) => {
    const heading = slide.querySelector('h1');
    if (!heading || heading.dataset.typingReady) return;

    const text = heading.textContent.trim();
    heading.dataset.fullText = text;
    heading.dataset.typingReady = 'true';
    heading.innerHTML = '<span class="typing-text"></span><span class="typing-cursor" aria-hidden="true"></span>';
};

const typeHeroHeading = (slide) => {
    const heading = slide.querySelector('h1');
    const textTarget = heading?.querySelector('.typing-text');
    const fullText = heading?.dataset.fullText || '';
    if (!heading || !textTarget || !fullText) return;

    window.clearInterval(heroTypingTimer);
    textTarget.textContent = '';
    heading.classList.add('is-typing');

    let letterIndex = 0;
    heroTypingTimer = window.setInterval(() => {
        textTarget.textContent = fullText.slice(0, letterIndex + 1);
        letterIndex += 1;

        if (letterIndex >= fullText.length) {
            window.clearInterval(heroTypingTimer);
            heading.classList.remove('is-typing');
        }
    }, 42);
};

const showSlide = (index) => {
    if (!slides.length) return;
    activeSlide = (index + slides.length) % slides.length;
    slides.forEach((slide, slideIndex) => slide.classList.toggle('active', slideIndex === activeSlide));
    [...(dotsWrap?.children || [])].forEach((dot, dotIndex) => dot.classList.toggle('active', dotIndex === activeSlide));
    typeHeroHeading(slides[activeSlide]);
};

const startHero = () => {
    window.clearInterval(heroTimer);
    if (heroPaused) return;
    heroTimer = window.setInterval(() => showSlide(activeSlide + 1), 6500);
};

const stopHero = () => {
    window.clearInterval(heroTimer);
};

const pauseHero = () => {
    heroPaused = true;
    stopHero();
};

const resumeHero = () => {
    heroPaused = false;
    startHero();
};

if (slides.length) {
    slides.forEach(prepareHeroHeading);

    if (dotsWrap) {
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Show slide ${index + 1}`);
            dot.addEventListener('click', () => {
                showSlide(index);
                startHero();
            });
            dotsWrap.appendChild(dot);
        });
    }

    document.querySelector('[data-prev]')?.addEventListener('click', () => {
        showSlide(activeSlide - 1);
        startHero();
    });

    document.querySelector('[data-next]')?.addEventListener('click', () => {
        showSlide(activeSlide + 1);
        startHero();
    });

    heroSlider?.addEventListener('pointerenter', pauseHero);
    heroSlider?.addEventListener('pointerleave', resumeHero);
    heroSlider?.addEventListener('mouseenter', pauseHero);
    heroSlider?.addEventListener('mouseleave', resumeHero);
    heroSlider?.addEventListener('focusin', pauseHero);
    heroSlider?.addEventListener('focusout', resumeHero);
    slides.forEach((slide) => {
        slide.addEventListener('pointerenter', pauseHero);
        slide.addEventListener('pointerleave', resumeHero);
        slide.addEventListener('mouseenter', pauseHero);
        slide.addEventListener('mouseleave', resumeHero);
    });

    showSlide(0);
    startHero();
}

const carousel = document.querySelector('[data-card-carousel]');
const scrollCards = (direction) => {
    if (!carousel) return;
    carousel.scrollBy({
        left: direction * Math.min(430, carousel.clientWidth * .9),
        behavior: 'smooth',
    });
};

document.querySelector('[data-card-prev]')?.addEventListener('click', () => scrollCards(-1));
document.querySelector('[data-card-next]')?.addEventListener('click', () => scrollCards(1));

const testimonialSlider = document.querySelector('[data-testimonial-slider]');
const testimonialSlides = [...document.querySelectorAll('[data-testimonial-slide]')];
const testimonialDots = [...document.querySelectorAll('[data-testimonial-dot]')];
let activeTestimonial = 0;
let testimonialTimer;
let testimonialPaused = false;

const setTestimonialSlideState = (slide, isActive) => {
    slide.classList.toggle('absolute', !isActive);
    slide.classList.toggle('inset-0', !isActive);
    slide.classList.toggle('pointer-events-none', !isActive);
    slide.classList.toggle('opacity-0', !isActive);
    slide.classList.toggle('translate-x-6', !isActive);
    slide.classList.toggle('opacity-100', isActive);
    slide.classList.toggle('translate-x-0', isActive);
};

const showTestimonial = (index) => {
    if (!testimonialSlides.length) return;
    activeTestimonial = (index + testimonialSlides.length) % testimonialSlides.length;

    testimonialSlides.forEach((slide, slideIndex) => {
        setTestimonialSlideState(slide, slideIndex === activeTestimonial);
    });

    testimonialDots.forEach((dot, dotIndex) => {
        const isActive = dotIndex === activeTestimonial;
        dot.setAttribute('aria-selected', String(isActive));
        dot.classList.toggle('w-8', isActive);
        dot.classList.toggle('w-2.5', !isActive);
        dot.classList.toggle('bg-sky-400', isActive);
        dot.classList.toggle('bg-slate-300', !isActive);
    });
};

const startTestimonials = () => {
    window.clearInterval(testimonialTimer);
    if (testimonialPaused || testimonialSlides.length < 2) return;
    testimonialTimer = window.setInterval(() => showTestimonial(activeTestimonial + 1), 5200);
};

const pauseTestimonials = () => {
    testimonialPaused = true;
    window.clearInterval(testimonialTimer);
};

const resumeTestimonials = () => {
    testimonialPaused = false;
    startTestimonials();
};

if (testimonialSlider && testimonialSlides.length) {
    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showTestimonial(index);
            startTestimonials();
        });
    });

    document.querySelector('[data-testimonial-prev]')?.addEventListener('click', () => {
        showTestimonial(activeTestimonial - 1);
        startTestimonials();
    });

    document.querySelector('[data-testimonial-next]')?.addEventListener('click', () => {
        showTestimonial(activeTestimonial + 1);
        startTestimonials();
    });

    testimonialSlider.addEventListener('pointerenter', pauseTestimonials);
    testimonialSlider.addEventListener('pointerleave', resumeTestimonials);
    testimonialSlider.addEventListener('focusin', pauseTestimonials);
    testimonialSlider.addEventListener('focusout', resumeTestimonials);

    showTestimonial(0);
    startTestimonials();
}

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: .15 });

document.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));

const countObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const number = entry.target;
        const target = Number(number.dataset.count || 0);
        const prefix = number.dataset.countPrefix || '';
        const suffix = number.dataset.countSuffix || '';
        const duration = 1300;
        const start = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            number.textContent = `${prefix}${Math.round(target * eased).toLocaleString()}${suffix}`;
            if (progress < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
        countObserver.unobserve(number);
    });
}, { threshold: .45 });

document.querySelectorAll('[data-count]').forEach((number) => {
    const prefix = number.dataset.countPrefix || '';
    const suffix = number.dataset.countSuffix || '';
    number.textContent = `${prefix}0${suffix}`;
    countObserver.observe(number);
});

backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

const aboutBody = document.querySelector('#aboutBodyText');
const aboutReadMore = document.querySelector('.about-dynamic-read-more');

if (aboutBody && aboutReadMore) {
    const updateAboutBodyOverflow = () => {
        aboutBody.classList.add('is-collapsed');
        aboutReadMore.hidden = aboutBody.scrollHeight <= aboutBody.clientHeight + 1;
    };

    updateAboutBodyOverflow();
    window.addEventListener('resize', updateAboutBodyOverflow);
}

document.querySelector('.search-modal__box')?.addEventListener('submit', (event) => {
    const input = event.currentTarget.querySelector('input[type="search"]');
    if (!input?.value.trim()) {
        event.preventDefault();
        input?.focus();
    }
});

const leadershipMessages = [...document.querySelectorAll('[data-leadership-message]')];

leadershipMessages.forEach((message) => {
    const text = message.querySelector('[data-leadership-message-text]');
    const link = message.querySelector('[data-leadership-message-link]');
    if (!text || !link) return;

    const updateOverflow = () => {
        link.hidden = text.scrollHeight <= text.clientHeight + 1;
    };

    updateOverflow();
    window.addEventListener('resize', updateOverflow);
});
