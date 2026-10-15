<?php

namespace App\Http\Controllers;

use App\Models\NursingPageSection;
use Illuminate\View\View;

class NursingController extends Controller
{
    public function __invoke(): View
    {
        $sections = NursingPageSection::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('nursing.index', [
            'hero' => $sections->firstWhere('section_type', 'hero'),
            'sections' => $sections->where('section_type', '!=', 'hero'),
        ]);
    }
}
