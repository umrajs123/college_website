<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampusEventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacultyMemberController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\LeadershipMessageController;
use App\Http\Controllers\Admin\NewsPostController;
use App\Models\CampusEvent;
use App\Models\FacultyMember;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $leadershipMessages = collect();
    $heroSlides = collect();

    if (Schema::hasTable('hero_slides')) {
        $heroSlides = HeroSlide::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    if (Schema::hasTable('leadership_messages')) {
        $leadershipMessages = LeadershipMessage::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    return view('welcome', [
        'heroSlides' => $heroSlides,
        'leadershipMessages' => $leadershipMessages,
        'campusEvents' => Schema::hasTable('campus_events')
            ? CampusEvent::active()->orderBy('starts_at')->orderBy('sort_order')->limit(3)->get()
            : collect(),
        'homeFaculty' => Schema::hasTable('faculty_members')
            ? FacultyMember::active()->orderBy('sort_order')->orderBy('name')->limit(3)->get()
            : collect(),
        'newsPosts' => Schema::hasTable('news_posts')
            ? NewsPost::active()->orderByDesc('published_at')->orderBy('sort_order')->limit(3)->get()
            : collect(),
    ]);
});

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.store');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/hero-slides', [HeroSlideController::class, 'index'])->name('hero-slides.index');
    Route::get('/hero-slides/create', [HeroSlideController::class, 'create'])->name('hero-slides.create');
    Route::post('/hero-slides', [HeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::get('/hero-slides/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('hero-slides.edit');
    Route::put('/hero-slides/{heroSlide}', [HeroSlideController::class, 'update'])->name('hero-slides.update');
    Route::get('/faculty', [FacultyMemberController::class, 'index'])->name('faculty.index');
    Route::get('/faculty/create', [FacultyMemberController::class, 'create'])->name('faculty.create');
    Route::post('/faculty', [FacultyMemberController::class, 'store'])->name('faculty.store');
    Route::get('/faculty/{facultyMember}/edit', [FacultyMemberController::class, 'edit'])->name('faculty.edit');
    Route::put('/faculty/{facultyMember}', [FacultyMemberController::class, 'update'])->name('faculty.update');
    Route::delete('/faculty/{facultyMember}', [FacultyMemberController::class, 'destroy'])->name('faculty.destroy');
    Route::get('/events', [CampusEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [CampusEventController::class, 'create'])->name('events.create');
    Route::post('/events', [CampusEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [CampusEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [CampusEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [CampusEventController::class, 'destroy'])->name('events.destroy');
    Route::get('/news', [NewsPostController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsPostController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsPostController::class, 'store'])->name('news.store');
    Route::get('/news/{post}/edit', [NewsPostController::class, 'edit'])->name('news.edit');
    Route::put('/news/{post}', [NewsPostController::class, 'update'])->name('news.update');
    Route::delete('/news/{post}', [NewsPostController::class, 'destroy'])->name('news.destroy');
    Route::get('/leadership', [LeadershipMessageController::class, 'index'])->name('leadership.index');
    Route::get('/leadership/create', [LeadershipMessageController::class, 'create'])->name('leadership.create');
    Route::post('/leadership', [LeadershipMessageController::class, 'store'])->name('leadership.store');
    Route::get('/leadership/{leadershipMessage}/edit', [LeadershipMessageController::class, 'edit'])->name('leadership.edit');
    Route::put('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'update'])->name('leadership.update');
    Route::delete('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'destroy'])->name('leadership.destroy');
});

Route::get('/events', function (Request $request) {
    $selectedCategory = trim((string) $request->input('category', ''));
    $selectedMonth = trim((string) $request->input('month', ''));

    $categories = CampusEvent::active()
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category')
        ->filter()
        ->values();

    $months = CampusEvent::active()
        ->orderBy('starts_at')
        ->get(['starts_at'])
        ->map(fn (CampusEvent $event) => [
            'value' => $event->starts_at->format('Y-m'),
            'label' => $event->starts_at->format('F Y'),
        ])
        ->unique('value')
        ->values();

    $eventsQuery = CampusEvent::active()->orderBy('starts_at')->orderBy('sort_order');

    if ($selectedCategory !== '') {
        $eventsQuery->where('category', $selectedCategory);
    }

    if ($selectedMonth !== '' && preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
        [$year, $month] = explode('-', $selectedMonth);
        $eventsQuery->whereYear('starts_at', $year)->whereMonth('starts_at', $month);
    }

    return view('events.index', [
        'events' => $eventsQuery->paginate(6)->withQueryString(),
        'categories' => $categories,
        'months' => $months,
        'selectedCategory' => $selectedCategory,
        'selectedMonth' => $selectedMonth,
    ]);
})->name('events.index');

Route::get('/news', function () {
    return view('news.index', [
        'posts' => NewsPost::active()
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(9),
    ]);
})->name('news.index');

Route::get('/news/{slug}', function (string $slug) {
    $post = NewsPost::active()->where('slug', $slug)->firstOrFail();

    return view('news.show', [
        'post' => $post,
        'latestPosts' => NewsPost::active()
            ->whereKeyNot($post->id)
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->limit(3)
            ->get(),
    ]);
})->name('news.show');

Route::get('/faculty', function () {
    return view('faculty.index', [
        'faculty' => FacultyMember::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(),
    ]);
})->name('faculty.index');

Route::get('/faculty/{slug}', function (string $slug) {
    $member = FacultyMember::active()->where('slug', $slug)->firstOrFail();

    return view('faculty.show', [
        'member' => $member,
        'faculty' => FacultyMember::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(),
    ]);
})->name('faculty.show');
