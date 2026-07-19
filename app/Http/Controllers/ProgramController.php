<?php

namespace App\Http\Controllers;

use App\Models\AcademicProgram;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function show(string $slug): View
    {
        $program = AcademicProgram::active()->where('slug', $slug)->firstOrFail();

        return view('programs.show', [
            'program' => $program,
            'programs' => AcademicProgram::active()
                ->whereKeyNot($program->id)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->limit(4)
                ->get(),
        ]);
    }
}
