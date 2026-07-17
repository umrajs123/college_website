<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicFacility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AcademicFacilityController extends Controller
{
    public function index(): View
    {
        return view('admin.facilities.index', [
            'facilities' => AcademicFacility::orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.facilities.edit', [
            'facility' => new AcademicFacility([
                'category' => 'Laboratory',
                'accent' => 'sky',
                'sort_order' => (AcademicFacility::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AcademicFacility::create($this->validatedFacility($request));

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Academic facility created successfully.');
    }

    public function edit(AcademicFacility $facility): View
    {
        return view('admin.facilities.edit', [
            'facility' => $facility,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, AcademicFacility $facility): RedirectResponse
    {
        $facility->update($this->validatedFacility($request, $facility));

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Academic facility updated successfully.');
    }

    public function destroy(AcademicFacility $facility): RedirectResponse
    {
        if ($facility->image_path && ! str_starts_with($facility->image_path, 'http')) {
            Storage::disk('public')->delete($facility->image_path);
        }

        $facility->delete();

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Academic facility deleted successfully.');
    }

    private function validatedFacility(Request $request, ?AcademicFacility $facility = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:700'],
            'image_path' => ['nullable', 'string', 'max:700'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:180'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($facility?->image_path && ! str_starts_with($facility->image_path, 'http')) {
                Storage::disk('public')->delete($facility->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('academic-facilities', 'public');
        }

        unset($validated['image']);

        return $validated;
    }
}
