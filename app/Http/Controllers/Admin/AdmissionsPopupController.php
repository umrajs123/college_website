<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdmissionsPopupController extends Controller
{
    public function edit(): View
    {
        return view('admin.admissions-popup.edit', [
            'settings' => SiteSetting::current(),
            'managedPrograms' => AcademicProgram::query()->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function storeProgram(Request $request, AcademicProgramController $programController): RedirectResponse
    {
        AcademicProgram::query()->create($programController->validatedProgram($request));

        return redirect()
            ->route('admin.admissions-popup.edit')
            ->with('status', 'Academic program added successfully.');
    }

    public function updateProgram(Request $request, AcademicProgram $program, AcademicProgramController $programController): RedirectResponse
    {
        $program->update($programController->validatedProgram($request, $program));

        return redirect()
            ->route('admin.admissions-popup.edit')
            ->with('status', 'Academic program updated successfully.');
    }

    public function destroyProgram(AcademicProgram $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('admin.admissions-popup.edit')
            ->with('status', 'Academic program deleted successfully.');
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = SiteSetting::query()->first() ?? new SiteSetting(SiteSetting::defaults());
        $validated = $request->validate([
            'admissions_popup_is_active' => ['required', 'boolean'],
            'admissions_popup_eyebrow' => ['required', 'string', 'max:100'],
            'admissions_popup_heading' => ['required', 'string', 'max:180'],
            'admissions_popup_body' => ['required', 'string', 'max:1000'],
            'admissions_popup_button_label' => ['required', 'string', 'max:60'],
            'admissions_popup_button_url' => ['nullable', 'url', 'max:700'],
            'admissions_popup_image_path' => ['nullable', 'string', 'max:700'],
            'admissions_popup_image' => ['nullable', 'image', 'max:4096'],
            'admissions_popup_session' => ['required', 'string', 'max:40'],
        ]);

        if ($request->hasFile('admissions_popup_image')) {
            $oldImage = $settings->admissions_popup_image_path;
            if ($oldImage && str_starts_with($oldImage, 'site-settings/')) {
                Storage::disk('public')->delete($oldImage);
            }

            $validated['admissions_popup_image_path'] = $request->file('admissions_popup_image')->store('site-settings', 'public');
        }

        unset($validated['admissions_popup_image']);

        $settings->fill($validated)->save();

        return redirect()
            ->route('admin.admissions-popup.edit')
            ->with('status', 'Admissions popup updated successfully.');
    }
}
