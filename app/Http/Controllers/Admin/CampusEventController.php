<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CampusEventController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => CampusEvent::orderBy('starts_at')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.edit', [
            'event' => new CampusEvent([
                'starts_at' => now()->addWeek()->setTime(10, 0),
                'category' => 'Event',
                'accent' => 'sky',
                'sort_order' => (CampusEvent::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CampusEvent::create($this->validateEvent($request));

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Campus event created successfully.');
    }

    public function edit(CampusEvent $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, CampusEvent $event): RedirectResponse
    {
        $event->update($this->validateEvent($request));

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Campus event updated successfully.');
    }

    public function destroy(CampusEvent $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Campus event deleted successfully.');
    }

    private function validateEvent(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:700'],
            'starts_at' => ['required', 'date'],
            'venue' => ['nullable', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
