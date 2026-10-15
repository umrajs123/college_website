<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NursingPageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NursingPageSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.nursing.index', [
            'sections' => NursingPageSection::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.nursing.edit', [
            'section' => new NursingPageSection([
                'section_type' => 'feature',
                'icon_label' => 'NC',
                'sort_order' => (NursingPageSection::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $section = NursingPageSection::create($this->validatedSection($request));
        $this->saveImage($request, $section, null);

        return redirect()
            ->route('admin.nursing.index')
            ->with('status', 'Nursing page section created successfully.');
    }

    public function edit(NursingPageSection $section): View
    {
        return view('admin.nursing.edit', [
            'section' => $section,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, NursingPageSection $section): RedirectResponse
    {
        $currentImage = $section->image_url;
        $section->update($this->validatedSection($request, $section));
        $this->saveImage($request, $section, $currentImage);

        return redirect()
            ->route('admin.nursing.index')
            ->with('status', 'Nursing page section updated successfully.');
    }

    public function destroy(NursingPageSection $section): RedirectResponse
    {
        if ($section->image_url && str_starts_with($section->image_url, 'nursing-page/')) {
            Storage::disk('public')->delete($section->image_url);
        }

        $section->delete();

        return redirect()
            ->route('admin.nursing.index')
            ->with('status', 'Nursing page section deleted successfully.');
    }

    private function validatedSection(Request $request, ?NursingPageSection $section = null): array
    {
        $sectionType = $request->input('section_type');
        $sectionTypeRules = ['required', Rule::in(['hero', 'content', 'feature', 'cta'])];

        if (in_array($sectionType, ['hero', 'cta'], true)) {
            $sectionTypeRules[] = Rule::unique('nursing_page_sections', 'section_type')
                ->where(fn ($query) => $query->where('section_type', $sectionType))
                ->ignore($section);
        }

        $validated = $request->validate([
            'section_type' => $sectionTypeRules,
            'eyebrow' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'max:10000'],
            'icon_label' => ['nullable', 'string', 'max:24'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'string', 'max:1000', 'regex:/^(https?:\/\/|\/(?!\/)|#[A-Za-z][A-Za-z0-9_:.-]*)/i'],
            'secondary_button_label' => ['nullable', 'string', 'max:80'],
            'secondary_button_url' => ['nullable', 'string', 'max:1000', 'regex:/^(https?:\/\/|\/(?!\/)|#[A-Za-z][A-Za-z0-9_:.-]*)/i'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        unset($validated['image'], $validated['remove_image']);

        if (! $request->filled('image_url') && ! $request->hasFile('image') && ! $request->boolean('remove_image')) {
            unset($validated['image_url']);
        }

        return $validated;
    }

    private function saveImage(Request $request, NursingPageSection $section, ?string $currentImage): void
    {
        if ($request->hasFile('image')) {
            $newImage = $request->file('image')->store('nursing-page', 'public');

            if ($currentImage && str_starts_with($currentImage, 'nursing-page/')) {
                Storage::disk('public')->delete($currentImage);
            }

            $section->update(['image_url' => $newImage]);

            return;
        }

        if ($request->boolean('remove_image')) {
            if ($currentImage && str_starts_with($currentImage, 'nursing-page/')) {
                Storage::disk('public')->delete($currentImage);
            }

            $section->update(['image_url' => null]);

            return;
        }

        if ($request->filled('image_url') && $request->input('image_url') !== $currentImage) {
            if ($currentImage && str_starts_with($currentImage, 'nursing-page/')) {
                Storage::disk('public')->delete($currentImage);
            }

            $section->update(['image_url' => $request->input('image_url')]);
        }
    }
}
