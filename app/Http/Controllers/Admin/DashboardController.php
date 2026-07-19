<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AcademicProgram;
use App\Models\AcademicFacility;
use App\Models\CampusEvent;
use App\Models\CampusLifeSection;
use App\Models\FacultyMember;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NewsPost;
use App\Models\StatCounter;
use App\Models\StudentVoice;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'heroSlideCount' => HeroSlide::count(),
            'activeHeroSlideCount' => HeroSlide::active()->count(),
            'facultyCount' => FacultyMember::count(),
            'activeFacultyCount' => FacultyMember::active()->count(),
            'eventCount' => CampusEvent::count(),
            'activeEventCount' => CampusEvent::active()->count(),
            'newsCount' => NewsPost::count(),
            'activeNewsCount' => NewsPost::active()->count(),
            'leadershipCount' => LeadershipMessage::count(),
            'activeLeadershipCount' => LeadershipMessage::active()->count(),
            'programCount' => AcademicProgram::count(),
            'activeProgramCount' => AcademicProgram::active()->count(),
            'statCount' => StatCounter::count(),
            'activeStatCount' => StatCounter::active()->count(),
            'studentVoiceCount' => StudentVoice::count(),
            'activeStudentVoiceCount' => StudentVoice::active()->count(),
            'facilityCount' => AcademicFacility::count(),
            'activeFacilityCount' => AcademicFacility::active()->count(),
            'aboutCount' => AboutSection::count(),
            'activeAboutCount' => AboutSection::active()->count(),
            'campusLifeCount' => CampusLifeSection::count(),
            'activeCampusLifeCount' => CampusLifeSection::where('is_active', true)->count(),
        ]);
    }
}
