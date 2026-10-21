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
use App\Http\Controllers\Admin\NursingPageSectionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\StatCounterController;
use App\Http\Controllers\Admin\StudentVoiceController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadershipMessageController as PublicLeadershipMessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NursingController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about.show');
Route::get('/search', SearchController::class)->name('search.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');
Route::get('/nursing', NursingController::class)->name('nursing.index');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty.index');
Route::get('/faculty/{slug}', [FacultyController::class, 'show'])->name('faculty.show');
Route::get('/leadership/{leadershipMessage}', [PublicLeadershipMessageController::class, 'show'])->name('leadership.show');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('guest')->name('admin.login.store');

/*
|--------------------------------------------------------------------------
| Admin Dashboard Modules
|--------------------------------------------------------------------------
| The route order below follows the sidebar order in the admin dashboard.
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // 01. Dashboard: admin overview and content summary.
    Route::get('/', DashboardController::class)->name('dashboard');

    // 02. Leadership Messages: Director and Principal messages.
    Route::get('/leadership', [LeadershipMessageController::class, 'index'])->name('leadership.index');
    Route::get('/leadership/create', [LeadershipMessageController::class, 'create'])->name('leadership.create');
    Route::post('/leadership', [LeadershipMessageController::class, 'store'])->name('leadership.store');
    Route::get('/leadership/{leadershipMessage}/edit', [LeadershipMessageController::class, 'edit'])->name('leadership.edit');
    Route::put('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'update'])->name('leadership.update');
    Route::delete('/leadership/{leadershipMessage}', [LeadershipMessageController::class, 'destroy'])->name('leadership.destroy');

    // 03. Hero Slides: homepage slider content.
    Route::get('/hero-slides', [HeroSlideController::class, 'index'])->name('hero-slides.index');
    Route::get('/hero-slides/create', [HeroSlideController::class, 'create'])->name('hero-slides.create');
    Route::post('/hero-slides', [HeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::get('/hero-slides/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('hero-slides.edit');
    Route::put('/hero-slides/{heroSlide}', [HeroSlideController::class, 'update'])->name('hero-slides.update');

    // 04. Faculty: faculty profiles and public directory.
    Route::get('/faculty', [FacultyMemberController::class, 'index'])->name('faculty.index');
    Route::get('/faculty/create', [FacultyMemberController::class, 'create'])->name('faculty.create');
    Route::post('/faculty', [FacultyMemberController::class, 'store'])->name('faculty.store');
    Route::get('/faculty/{facultyMember}/edit', [FacultyMemberController::class, 'edit'])->name('faculty.edit');
    Route::put('/faculty/{facultyMember}', [FacultyMemberController::class, 'update'])->name('faculty.update');
    Route::delete('/faculty/{facultyMember}', [FacultyMemberController::class, 'destroy'])->name('faculty.destroy');

    // 05. Events: campus calendar and event listings.
    Route::get('/events', [CampusEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [CampusEventController::class, 'create'])->name('events.create');
    Route::post('/events', [CampusEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [CampusEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [CampusEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [CampusEventController::class, 'destroy'])->name('events.destroy');

    // 06. News: announcements and story posts.
    Route::get('/news', [NewsPostController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsPostController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsPostController::class, 'store'])->name('news.store');
    Route::get('/news/{post}/edit', [NewsPostController::class, 'edit'])->name('news.edit');
    Route::put('/news/{post}', [NewsPostController::class, 'update'])->name('news.update');
    Route::delete('/news/{post}', [NewsPostController::class, 'destroy'])->name('news.destroy');

    // 07. Programs: academic areas and program detail pages.
    Route::get('/programs', [AcademicProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/create', [AcademicProgramController::class, 'create'])->name('programs.create');
    Route::post('/programs', [AcademicProgramController::class, 'store'])->name('programs.store');
    Route::get('/programs/{program}/edit', [AcademicProgramController::class, 'edit'])->name('programs.edit');
    Route::put('/programs/{program}', [AcademicProgramController::class, 'update'])->name('programs.update');
    Route::delete('/programs/{program}', [AcademicProgramController::class, 'destroy'])->name('programs.destroy');

    // Nursing: dedicated public Nursing College page content.
    Route::get('/nursing', [NursingPageSectionController::class, 'index'])->name('nursing.index');
    Route::get('/nursing/create', [NursingPageSectionController::class, 'create'])->name('nursing.create');
    Route::post('/nursing', [NursingPageSectionController::class, 'store'])->name('nursing.store');
    Route::get('/nursing/{section}/edit', [NursingPageSectionController::class, 'edit'])->name('nursing.edit');
    Route::put('/nursing/{section}', [NursingPageSectionController::class, 'update'])->name('nursing.update');
    Route::delete('/nursing/{section}', [NursingPageSectionController::class, 'destroy'])->name('nursing.destroy');

    // 08. Stats: homepage animated counter values.
    Route::get('/stats', [StatCounterController::class, 'index'])->name('stats.index');
    Route::get('/stats/create', [StatCounterController::class, 'create'])->name('stats.create');
    Route::post('/stats', [StatCounterController::class, 'store'])->name('stats.store');
    Route::get('/stats/{stat}/edit', [StatCounterController::class, 'edit'])->name('stats.edit');
    Route::put('/stats/{stat}', [StatCounterController::class, 'update'])->name('stats.update');
    Route::delete('/stats/{stat}', [StatCounterController::class, 'destroy'])->name('stats.destroy');

    // 09. Student Voices: testimonials shown on the homepage.
    Route::get('/student-voices', [StudentVoiceController::class, 'index'])->name('student-voices.index');
    Route::get('/student-voices/create', [StudentVoiceController::class, 'create'])->name('student-voices.create');
    Route::post('/student-voices', [StudentVoiceController::class, 'store'])->name('student-voices.store');
    Route::get('/student-voices/{voice}/edit', [StudentVoiceController::class, 'edit'])->name('student-voices.edit');
    Route::put('/student-voices/{voice}', [StudentVoiceController::class, 'update'])->name('student-voices.update');
    Route::delete('/student-voices/{voice}', [StudentVoiceController::class, 'destroy'])->name('student-voices.destroy');

    // 10. Facilities: labs and featured academic facilities.
    Route::get('/facilities', [AcademicFacilityController::class, 'index'])->name('facilities.index');
    Route::get('/facilities/create', [AcademicFacilityController::class, 'create'])->name('facilities.create');
    Route::post('/facilities', [AcademicFacilityController::class, 'store'])->name('facilities.store');
    Route::get('/facilities/{facility}/edit', [AcademicFacilityController::class, 'edit'])->name('facilities.edit');
    Route::put('/facilities/{facility}', [AcademicFacilityController::class, 'update'])->name('facilities.update');
    Route::delete('/facilities/{facility}', [AcademicFacilityController::class, 'destroy'])->name('facilities.destroy');

    // 11. About: homepage about section content.
    Route::get('/about', [AboutSectionController::class, 'index'])->name('about.index');
    Route::get('/about/{section}/edit', [AboutSectionController::class, 'edit'])->whereNumber('section')->name('about.edit');
    Route::put('/about/{section}', [AboutSectionController::class, 'update'])->whereNumber('section')->name('about.update');
    Route::delete('/about/{section}', [AboutSectionController::class, 'destroy'])->whereNumber('section')->name('about.destroy');

    // 12. Campus Life: student experience content block.
    Route::get('/campus-life', [CampusLifeSectionController::class, 'edit'])->name('campus-life.edit');
    Route::put('/campus-life', [CampusLifeSectionController::class, 'update'])->name('campus-life.update');

    // 13. Site Settings: logo, contact info, admissions link, and footer values.
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // 14. Security: admin password and account access.
    Route::get('/security', [AuthController::class, 'editPassword'])->name('security.edit');
    Route::put('/security', [AuthController::class, 'updatePassword'])->name('security.update');

    // Account session: logout from the admin panel.
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
