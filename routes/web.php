<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AcademicFacilityController;
use App\Http\Controllers\Admin\AcademicProgramController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampusEventController;
use App\Http\Controllers\Admin\CampusLifeSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacultyMemberController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\LeadershipMessageController;
use App\Http\Controllers\Admin\NewsPostController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\StatCounterController;
use App\Http\Controllers\Admin\StudentVoiceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('guest')->name('admin.login.store');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/security', [AuthController::class, 'editPassword'])->name('security.edit');
    Route::put('/security', [AuthController::class, 'updatePassword'])->name('security.update');

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

    Route::get('/programs', [AcademicProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [AcademicProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [AcademicProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}/edit', [AcademicProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [AcademicProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [AcademicProgramController::class, 'destroy'])->name('programs.destroy');

    Route::get('/stats', [StatCounterController::class, 'index'])->name('stats.index');
    Route::get('/stats/create', [StatCounterController::class, 'create'])->name('stats.create');
    Route::post('/stats', [StatCounterController::class, 'store'])->name('stats.store');
    Route::get('/stats/{stat}/edit', [StatCounterController::class, 'edit'])->name('stats.edit');
    Route::put('/stats/{stat}', [StatCounterController::class, 'update'])->name('stats.update');
    Route::delete('/stats/{stat}', [StatCounterController::class, 'destroy'])->name('stats.destroy');

    Route::get('/student-voices', [StudentVoiceController::class, 'index'])->name('student-voices.index');
    Route::get('/student-voices/create', [StudentVoiceController::class, 'create'])->name('student-voices.create');
    Route::post('/student-voices', [StudentVoiceController::class, 'store'])->name('student-voices.store');
    Route::get('/student-voices/{voice}/edit', [StudentVoiceController::class, 'edit'])->name('student-voices.edit');
    Route::put('/student-voices/{voice}', [StudentVoiceController::class, 'update'])->name('student-voices.update');
    Route::delete('/student-voices/{voice}', [StudentVoiceController::class, 'destroy'])->name('student-voices.destroy');

    Route::get('/facilities', [AcademicFacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [AcademicFacilityController::class, 'create'])->name('facilities.create');
    Route::post('/facilities', [AcademicFacilityController::class, 'store'])->name('facilities.store');
    Route::get('/facilities/{facility}/edit', [AcademicFacilityController::class, 'edit'])->name('facilities.edit');
    Route::put('/facilities/{facility}', [AcademicFacilityController::class, 'update'])->name('facilities.update');
    Route::delete('/facilities/{facility}', [AcademicFacilityController::class, 'destroy'])->name('facilities.destroy');

    Route::get('/about', [AboutSectionController::class, 'index'])->name('about.index');
    Route::get('/about/create', [AboutSectionController::class, 'create'])->name('about.create');
    Route::post('/about', [AboutSectionController::class, 'store'])->name('about.store');
    Route::get('/about/{section}/edit', [AboutSectionController::class, 'edit'])->name('about.edit');
    Route::put('/about/{section}', [AboutSectionController::class, 'update'])->name('about.update');
    Route::delete('/about/{section}', [AboutSectionController::class, 'destroy'])->name('about.destroy');

    Route::get('/campus-life', [CampusLifeSectionController::class, 'edit'])->name('campus-life.edit');
    Route::put('/campus-life', [CampusLifeSectionController::class, 'update'])->name('campus-life.update');

    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::get('/leadership', [LeadershipMessageController::class, 'index'])->name('leadership.index');
    Route::get('/leadership/create', [LeadershipMessageController::class, 'create'])->name('leadership.create');
    Route::post('/leadership', [LeadershipMessageController::class, 'store'])->name('leadership.store');
    Route::get('/leadership/{leadershipMessage}/edit', [LeadershipMessageController::class, 'edit'])->name('leadership.edit');
    Route::put('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'update'])->name('leadership.update');
    Route::delete('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'destroy'])->name('leadership.destroy');
});

Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');
Route::get('/search', SearchController::class)->name('search.index');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty.index');
Route::get('/faculty/{slug}', [FacultyController::class, 'show'])->name('faculty.show');
