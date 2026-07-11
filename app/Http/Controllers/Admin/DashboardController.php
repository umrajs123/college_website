<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusEvent;
use App\Models\FacultyMember;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NewsPost;
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
        ]);
    }
}
