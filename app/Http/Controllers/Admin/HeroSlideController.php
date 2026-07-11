<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => new HeroSlide([
                'sort_order' => (HeroSlide::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSlide($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        HeroSlide::create($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('status', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => $heroSlide,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $validated = $this->validateSlide($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $heroSlide->update($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('status', 'Hero slide updated successfully.');
    }

    private function validateSlide(Request $request): array
    {
        return $request->validate([
            'eyebrow' => ['required', 'string', 'max:120'],
            'heading' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['required_without:image', 'nullable', 'string', 'max:700'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'primary_label' => ['nullable', 'string', 'max:80'],
            'primary_url' => ['nullable', 'string', 'max:200'],
            'secondary_label' => ['nullable', 'string', 'max:80'],
            'secondary_url' => ['nullable', 'string', 'max:200'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
