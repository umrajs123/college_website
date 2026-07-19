<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusLifeSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CampusLifeSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.campus-life.edit', [
            'section' => CampusLifeSection::query()->first() ?? new CampusLifeSection(CampusLifeSection::defaults()),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $section = CampusLifeSection::query()->first() ?? new CampusLifeSection();
        $validated = $request->validate([
            'eyebrow' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:180'],
            'body' => ['nullable', 'string', 'max:900'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'image_badge' => ['nullable', 'string', 'max:80'],
            'image_heading' => ['nullable', 'string', 'max:180'],
            'card_title' => ['nullable', 'array', 'max:3'],
            'card_title.*' => ['nullable', 'string', 'max:100'],
            'card_text' => ['nullable', 'array', 'max:3'],
            'card_text.*' => ['nullable', 'string', 'max:260'],
            'card_accent' => ['nullable', 'array', 'max:3'],
            'card_accent.*' => ['nullable', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'highlight_label' => ['nullable', 'array', 'max:3'],
            'highlight_label.*' => ['nullable', 'string', 'max:80'],
            'highlight_value' => ['nullable', 'array', 'max:3'],
            'highlight_value.*' => ['nullable', 'string', 'max:80'],
            'highlight_accent' => ['nullable', 'array', 'max:3'],
            'highlight_accent.*' => ['nullable', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['cards'] = $this->buildCards($request);
        $validated['highlights'] = $this->buildHighlights($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($section->image_path && ! str_starts_with($section->image_path, 'http')) {
                Storage::disk('public')->delete($section->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('campus-life', 'public');
        }

        unset(
            $validated['image'],
            $validated['card_title'],
            $validated['card_text'],
            $validated['card_accent'],
            $validated['highlight_label'],
            $validated['highlight_value'],
            $validated['highlight_accent'],
        );

        $section->fill($validated)->save();

        return redirect()
            ->route('admin.campus-life.edit')
            ->with('status', 'Campus Life section updated successfully.');
    }

    private function buildCards(Request $request): array
    {
        $cards = [];
        for ($index = 0; $index < 3; $index++) {
            $title = trim((string) $request->input("card_title.$index", ''));
            $text = trim((string) $request->input("card_text.$index", ''));
            if ($title === '' && $text === '') continue;
            $cards[] = [
                'title' => $title,
                'text' => $text,
                'accent' => $request->input("card_accent.$index", 'sky'),
            ];
        }

        return $cards;
    }

    private function buildHighlights(Request $request): array
    {
        $highlights = [];
        for ($index = 0; $index < 3; $index++) {
            $label = trim((string) $request->input("highlight_label.$index", ''));
            $value = trim((string) $request->input("highlight_value.$index", ''));
            if ($label === '' && $value === '') continue;
            $highlights[] = [
                'label' => $label,
                'value' => $value,
                'accent' => $request->input("highlight_accent.$index", 'sky'),
            ];
        }

        return $highlights;
    }
}
