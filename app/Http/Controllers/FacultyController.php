<?php

namespace App\Http\Controllers;

use App\Models\FacultyMember;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        return view('faculty.index', [
            'faculty' => FacultyMember::active()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $member = FacultyMember::active()->where('slug', $slug)->firstOrFail();

        return view('faculty.show', [
            'member' => $member,
            'faculty' => FacultyMember::active()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
