<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentVoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentVoiceController extends Controller
{
    public function index(): View
    {
        return view('admin.student-voices.index', [
            'voices' => StudentVoice::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.student-voices.edit', [
            'voice' => new StudentVoice([
                'accent' => 'sky',
                'sort_order' => (StudentVoice::max('sort_order') ?? 0) + 1,
                'is_active' => true,
                'highlights' => [],
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        StudentVoice::create($this->validatedVoice($request));

        return redirect()
            ->route('admin.student-voices.index')
            ->with('status', 'Student voice created successfully.');
    }

    public function edit(StudentVoice $voice): View
    {
        return view('admin.student-voices.edit', [
            'voice' => $voice,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, StudentVoice $voice): RedirectResponse
    {
        $voice->update($this->validatedVoice($request, $voice));

        return redirect()
            ->route('admin.student-voices.index')
            ->with('status', 'Student voice updated successfully.');
    }

    public function destroy(StudentVoice $voice): RedirectResponse
    {
        if ($voice->image_path && ! str_starts_with($voice->image_path, 'http')) {
            Storage::disk('public')->delete($voice->image_path);
        }

        $voice->delete();

        return redirect()
            ->route('admin.student-voices.index')
            ->with('status', 'Student voice deleted successfully.');
    }

    private function validatedVoice(Request $request, ?StudentVoice $voice = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'program' => ['nullable', 'string', 'max:140'],
            'quote' => ['required', 'string', 'max:900'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'highlight_title' => ['nullable', 'array', 'max:3'],
            'highlight_title.*' => ['nullable', 'string', 'max:50'],
            'highlight_text' => ['nullable', 'array', 'max:3'],
            'highlight_text.*' => ['nullable', 'string', 'max:80'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['highlights'] = $this->buildHighlights(
            $request->input('highlight_title', []),
            $request->input('highlight_text', [])
        );

        if ($request->hasFile('image')) {
            if ($voice?->image_path && ! str_starts_with($voice->image_path, 'http')) {
                Storage::disk('public')->delete($voice->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('student-voices', 'public');
        }

        unset($validated['image'], $validated['highlight_title'], $validated['highlight_text']);

        return $validated;
    }

    private function buildHighlights(array $titles, array $texts): array
    {
        $highlights = [];

        for ($index = 0; $index < 3; $index++) {
            $title = trim((string) ($titles[$index] ?? ''));
            $text = trim((string) ($texts[$index] ?? ''));

            if ($title === '' && $text === '') {
                continue;
            }

            $highlights[] = [
                'title' => $title,
                'text' => $text,
            ];
        }

        return $highlights;
    }
}
