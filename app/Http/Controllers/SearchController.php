<?php

namespace App\Http\Controllers;

use App\Models\AcademicFacility;
use App\Models\AcademicProgram;
use App\Models\CampusEvent;
use App\Models\FacultyMember;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $results = collect();

        if ($query !== '') {
            $like = '%'.$query.'%';

            $results = $results
                ->merge($this->programResults($like))
                ->merge($this->facultyResults($like))
                ->merge($this->newsResults($like))
                ->merge($this->eventResults($like))
                ->merge($this->facilityResults($like))
                ->take(24)
                ->values();
        }

        return view('search.index', [
            'query' => $query,
            'results' => $results,
        ]);
    }

    private function programResults(string $like)
    {
        return AcademicProgram::active()
            ->where(fn ($builder) => $builder
                ->where('title', 'like', $like)
                ->orWhere('description', 'like', $like)
                ->orWhere('overview', 'like', $like))
            ->limit(8)
            ->get()
            ->map(fn (AcademicProgram $program) => [
                'type' => 'Program',
                'title' => $program->title,
                'excerpt' => $program->description ?: $program->overview,
                'url' => $program->publicUrl(),
            ]);
    }

    private function facultyResults(string $like)
    {
        return FacultyMember::active()
            ->where(fn ($builder) => $builder
                ->where('name', 'like', $like)
                ->orWhere('designation', 'like', $like)
                ->orWhere('department', 'like', $like)
                ->orWhere('summary', 'like', $like))
            ->limit(8)
            ->get()
            ->map(fn (FacultyMember $member) => [
                'type' => 'Faculty',
                'title' => $member->name,
                'excerpt' => trim(($member->designation ? $member->designation.'. ' : '').($member->summary ?: $member->department)),
                'url' => route('faculty.show', $member->slug),
            ]);
    }

    private function newsResults(string $like)
    {
        return NewsPost::active()
            ->where(fn ($builder) => $builder
                ->where('title', 'like', $like)
                ->orWhere('excerpt', 'like', $like)
                ->orWhere('body', 'like', $like)
                ->orWhere('category', 'like', $like))
            ->limit(8)
            ->get()
            ->map(fn (NewsPost $post) => [
                'type' => 'News',
                'title' => $post->title,
                'excerpt' => $post->excerpt ?: $post->category,
                'url' => route('news.show', $post->slug),
            ]);
    }

    private function eventResults(string $like)
    {
        return CampusEvent::active()
            ->where(fn ($builder) => $builder
                ->where('title', 'like', $like)
                ->orWhere('description', 'like', $like)
                ->orWhere('category', 'like', $like)
                ->orWhere('venue', 'like', $like))
            ->limit(8)
            ->get()
            ->map(fn (CampusEvent $event) => [
                'type' => 'Event',
                'title' => $event->title,
                'excerpt' => trim(($event->venue ? $event->venue.'. ' : '').($event->description ?: $event->category)),
                'url' => route('events.index'),
            ]);
    }

    private function facilityResults(string $like)
    {
        return AcademicFacility::active()
            ->where(fn ($builder) => $builder
                ->where('title', 'like', $like)
                ->orWhere('description', 'like', $like)
                ->orWhere('category', 'like', $like))
            ->limit(8)
            ->get()
            ->map(fn (AcademicFacility $facility) => [
                'type' => 'Facility',
                'title' => $facility->title,
                'excerpt' => $facility->description ?: $facility->category,
                'url' => url('/').'#labs',
            ]);
    }
}
