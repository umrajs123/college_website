<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\SiteSetting;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $aboutSection = AboutSection::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->firstOrFail();

        $paragraphs = collect(preg_split("/\r\n|\n|\r/", trim((string) $aboutSection->body)))
            ->map(fn ($paragraph) => trim($paragraph))
            ->filter()
            ->values();

        return view('about.show', [
            'aboutSection' => $aboutSection,
            'paragraphs' => $paragraphs,
            'siteSettings' => SiteSetting::current(),
        ]);
    }
}
