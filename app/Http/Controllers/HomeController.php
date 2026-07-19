<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\AcademicFacility;
use App\Models\AcademicProgram;
use App\Models\CampusEvent;
use App\Models\CampusLifeSection;
use App\Models\FacultyMember;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NewsPost;
use App\Models\StatCounter;
use App\Models\StudentVoice;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'heroSlides' => $this->activeOrdered('hero_slides', HeroSlide::class, ['sort_order', 'id']),
            'leadershipMessages' => $this->activeOrdered('leadership_messages', LeadershipMessage::class, ['sort_order', 'id']),
            'campusEvents' => $this->activeOrdered('campus_events', CampusEvent::class, ['starts_at', 'sort_order'], 3),
            'homeFaculty' => $this->activeOrdered('faculty_members', FacultyMember::class, ['sort_order', 'name'], 3),
            'newsPosts' => Schema::hasTable('news_posts')
                ? NewsPost::active()->orderByDesc('published_at')->orderBy('sort_order')->limit(3)->get()
                : collect(),
            'academicPrograms' => $this->activeOrdered('academic_programs', AcademicProgram::class, ['sort_order', 'title']),
            'statCounters' => $this->activeOrdered('stat_counters', StatCounter::class, ['sort_order', 'label']),
            'studentVoices' => $this->activeOrdered('student_voices', StudentVoice::class, ['sort_order', 'name']),
            'academicFacilities' => $this->activeOrdered('academic_facilities', AcademicFacility::class, ['sort_order', 'title']),
            'aboutSection' => Schema::hasTable('about_sections')
                ? AboutSection::active()->orderBy('sort_order')->orderBy('id')->first()
                : null,
            'campusLifeSection' => CampusLifeSection::current(),
        ]);
    }

    private function activeOrdered(string $table, string $model, array $orders, ?int $limit = null)
    {
        if (! Schema::hasTable($table)) {
            return collect();
        }

        $query = $model::active();

        foreach ($orders as $order) {
            $query->orderBy($order);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
