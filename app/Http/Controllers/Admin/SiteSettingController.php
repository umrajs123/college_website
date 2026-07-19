<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = SiteSetting::query()->first() ?? new SiteSetting();
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'site_tagline' => ['nullable', 'string', 'max:160'],
            'site_description' => ['nullable', 'string', 'max:500'],
            'logo_path' => ['nullable', 'string', 'max:700'],
            'favicon_path' => ['nullable', 'string', 'max:700'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:160'],
            'address' => ['nullable', 'string', 'max:260'],
            'admissions_url' => ['nullable', 'url', 'max:700'],
            'facebook_url' => ['nullable', 'url', 'max:700'],
            'linkedin_url' => ['nullable', 'url', 'max:700'],
            'youtube_url' => ['nullable', 'url', 'max:700'],
            'privacy_url' => ['nullable', 'string', 'max:700'],
        ]);

        if ($request->hasFile('logo')) {
            $this->deleteStoredFile($settings->logo_path);
            $validated['logo_path'] = $request->file('logo')->store('site-settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $this->deleteStoredFile($settings->favicon_path);
            $validated['favicon_path'] = $request->file('favicon')->store('site-settings', 'public');
        }

        unset($validated['logo'], $validated['favicon']);

        $settings->fill($validated)->save();

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Site settings updated successfully.');
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'site-settings/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
