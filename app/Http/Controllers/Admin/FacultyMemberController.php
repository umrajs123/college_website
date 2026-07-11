<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacultyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FacultyMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.faculty.index', [
            'faculty' => FacultyMember::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.faculty.edit', [
            'member' => new FacultyMember([
                'sort_order' => (FacultyMember::max('sort_order') ?? 0) + 1,
                'is_active' => true,
                'accent' => 'sky',
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFaculty($request);
        $validated = $this->preparePayload($request, $validated);

        FacultyMember::create($validated);

        return redirect()
            ->route('admin.faculty.index')
            ->with('status', 'Faculty member created successfully.');
    }

    public function edit(FacultyMember $facultyMember): View
    {
        return view('admin.faculty.edit', [
            'member' => $facultyMember,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, FacultyMember $facultyMember): RedirectResponse
    {
        $validated = $this->validateFaculty($request, $facultyMember);
        $validated = $this->preparePayload($request, $validated);

        $facultyMember->update($validated);

        return redirect()
            ->route('admin.faculty.index')
            ->with('status', 'Faculty member updated successfully.');
    }

    public function destroy(FacultyMember $facultyMember): RedirectResponse
    {
        if ($facultyMember->image_path && ! str_starts_with($facultyMember->image_path, 'http')) {
            Storage::disk('public')->delete($facultyMember->image_path);
        }

        $facultyMember->delete();

        return redirect()
            ->route('admin.faculty.index')
            ->with('status', 'Faculty member deleted successfully.');
    }

    private function validateFaculty(Request $request, ?FacultyMember $facultyMember = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        return $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'slug' => [
                'required',
                'string',
                'max:160',
                Rule::unique('faculty_members', 'slug')->ignore($facultyMember?->id),
            ],
            'designation' => ['required', 'string', 'max:180'],
            'department' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'accent' => ['required', 'string', 'max:40'],
            'summary' => ['required', 'string', 'max:500'],
            'bio' => ['required', 'string', 'max:3000'],
            'education' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:255'],
            'specialties' => ['nullable', 'string', 'max:700'],
            'courses' => ['nullable', 'string', 'max:700'],
            'email' => ['nullable', 'email', 'max:180'],
            'office' => ['nullable', 'string', 'max:180'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function preparePayload(Request $request, array $validated): array
    {
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('faculty', 'public');
        }

        $validated['specialties'] = $this->splitList($validated['specialties'] ?? '');
        $validated['courses'] = $this->splitList($validated['courses'] ?? '');
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    private function splitList(string $value): array
    {
        return collect(explode(',', $value))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
