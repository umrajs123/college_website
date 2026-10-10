<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AboutSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.about.index', [
            'sections' => AboutSection::orderBy('sort_order')->orderBy('heading')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.about.edit', [
            'section' => new AboutSection([
                'eyebrow' => 'About SCPS',
                'badge_value' => '15+',
                'button_label' => 'Request Information',
                'button_url' => '#contact',
                'accent' => 'sky',
                'sort_order' => (AboutSection::max('sort_order') ?? 0) + 1,
                'is_active' => true,
                'features' => [],
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AboutSection::create($this->validatedSection($request));

        return redirect()
            ->route('admin.about.index')
            ->with('status', 'About section created successfully.');
    }

    public function edit(AboutSection $section): View
    {
        return view('admin.about.edit', [
            'section' => $section,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, AboutSection $section): RedirectResponse
    {
        $section->update($this->validatedSection($request, $section));

        return redirect()
            ->route('admin.about.index')
            ->with('status', 'About section updated successfully.');
    }

    public function destroy(AboutSection $section): RedirectResponse
    {
        if ($section->image_path && ! str_starts_with($section->image_path, 'http')) {
            Storage::disk('public')->delete($section->image_path);
        }

        $section->delete();

        return redirect()
            ->route('admin.about.index')
            ->with('status', 'About section deleted successfully.');
    }

    private function validatedSection(Request $request, ?AboutSection $section = null): array
    {
        $validated = $request->validate([
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:180'],
            'body' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'badge_value' => ['nullable', 'string', 'max:40'],
            'badge_label' => ['nullable', 'string', 'max:140'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'string', 'max:700'],
            'feature_text' => ['nullable', 'array', 'max:3'],
            'feature_text.*' => ['nullable', 'string', 'max:160'],
            'feature_accent' => ['nullable', 'array', 'max:3'],
            'feature_accent.*' => ['nullable', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['features'] = $this->buildFeatures(
            $request->input('feature_text', []),
            $request->input('feature_accent', [])
        );

        if ($request->hasFile('image')) {
            if ($section?->image_path && ! str_starts_with($section->image_path, 'http')) {
                Storage::disk('public')->delete($section->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('about', 'public');
        }

        unset($validated['image'], $validated['feature_text'], $validated['feature_accent']);

        return $validated;
    }

    private function buildFeatures(array $texts, array $accents): array
    {
        $features = [];

        for ($index = 0; $index < 3; $index++) {
            $text = trim((string) ($texts[$index] ?? ''));

            if ($text === '') {
                continue;
            }

            $features[] = [
                'text' => $text,
                'accent' => $accents[$index] ?? 'sky',
            ];
        }

        return $features;
    }
}
