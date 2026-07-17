<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AcademicProgramController extends Controller
{
    public function index(): View
    {
        return view('admin.programs.index', [
            'programs' => AcademicProgram::orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.edit', [
            'program' => new AcademicProgram([
                'icon_label' => 'Rx',
                'accent' => 'sky',
                'sort_order' => (AcademicProgram::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AcademicProgram::create($this->validatedProgram($request));

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Academic program created successfully.');
    }

    public function edit(AcademicProgram $program): View
    {
        return view('admin.programs.edit', [
            'program' => $program,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, AcademicProgram $program): RedirectResponse
    {
        $program->update($this->validatedProgram($request, $program));

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Academic program updated successfully.');
    }

    public function destroy(AcademicProgram $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Academic program deleted successfully.');
    }

    private function validatedProgram(Request $request, ?AcademicProgram $program = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('title')),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('academic_programs', 'slug')->ignore($program)],
            'icon_label' => ['required', 'string', 'max:16'],
            'description' => ['nullable', 'string', 'max:700'],
            'duration' => ['nullable', 'string', 'max:120'],
            'eligibility' => ['nullable', 'string', 'max:220'],
            'overview' => ['nullable', 'string'],
            'learning_focus' => ['nullable', 'string'],
            'career_scope' => ['nullable', 'string'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'link_url' => ['nullable', 'string', 'max:700'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
