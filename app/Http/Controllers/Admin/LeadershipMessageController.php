<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LeadershipMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.leadership.index', [
            'messages' => LeadershipMessage::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.leadership.edit', [
            'message' => new LeadershipMessage([
                'accent' => 'director',
                'sort_order' => (LeadershipMessage::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMessage($request);
        $validated = $this->preparePayload($request, $validated);

        LeadershipMessage::create($validated);

        return redirect()
            ->route('admin.leadership.index')
            ->with('status', 'Leadership message created successfully.');
    }

    public function edit(LeadershipMessage $leadershipMessage): View
    {
        return view('admin.leadership.edit', [
            'message' => $leadershipMessage,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, LeadershipMessage $leadershipMessage): RedirectResponse
    {
        $validated = $this->validateMessage($request);
        $validated = $this->preparePayload($request, $validated);

        $leadershipMessage->update($validated);

        return redirect()
            ->route('admin.leadership.index')
            ->with('status', 'Leadership message updated successfully.');
    }

    public function destroy(LeadershipMessage $leadershipMessage): RedirectResponse
    {
        if ($leadershipMessage->image_path && ! str_starts_with($leadershipMessage->image_path, 'http')) {
            Storage::disk('public')->delete($leadershipMessage->image_path);
        }

        $leadershipMessage->delete();

        return redirect()
            ->route('admin.leadership.index')
            ->with('status', 'Leadership message deleted successfully.');
    }

    private function validateMessage(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:120'],
            'subtitle' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['nullable', 'string', 'max:500'],
            'tags' => ['nullable', 'string', 'max:240'],
            'accent' => ['required', Rule::in(['director', 'principal'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function preparePayload(Request $request, array $validated): array
    {
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('leadership', 'public');
        }

        $validated['tags'] = collect(explode(',', $validated['tags'] ?? ''))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
        $validated['is_active'] = $request->boolean('is_active');

        unset($validated['image']);

        return $validated;
    }
}
