<?php

namespace App\Http\Controllers;

use App\Models\AcademicProgram;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function show(string $slug): View
    {
        $program = AcademicProgram::active()->where('slug', $slug)->firstOrFail();

        $sections = collect([
            'Program Overview' => $program->overview ?: $program->description,
            'Learning Focus' => $program->learning_focus,
            'Career Direction' => $program->career_scope,
        ])->filter(fn ($value) => filled($value))
            ->map(fn ($value) => collect(preg_split("/\r\n|\n|\r/", trim((string) $value)))
                ->map(fn ($paragraph) => trim($paragraph))
                ->filter()
                ->values());

        return view('programs.show', [
            'program' => $program,
            'sections' => $sections,
            'programs' => AcademicProgram::active()
                ->whereKeyNot($program->id)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->limit(4)
                ->get(),
        ]);
    }
}
