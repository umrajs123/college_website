<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatCounter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatCounterController extends Controller
{
    public function index(): View
    {
        return view('admin.stats.index', [
            'stats' => StatCounter::orderBy('sort_order')->orderBy('label')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.stats.edit', [
            'stat' => new StatCounter([
                'value' => 100,
                'suffix' => '+',
                'icon_label' => '#',
                'accent' => 'sky',
                'sort_order' => (StatCounter::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        StatCounter::create($this->validatedStat($request));

        return redirect()
            ->route('admin.stats.index')
            ->with('status', 'Statistic created successfully.');
    }

    public function edit(StatCounter $stat): View
    {
        return view('admin.stats.edit', [
            'stat' => $stat,
            'isCreate' => false,
        ]);
    }

    public function update(Request $request, StatCounter $stat): RedirectResponse
    {
        $stat->update($this->validatedStat($request));

        return redirect()
            ->route('admin.stats.index')
            ->with('status', 'Statistic updated successfully.');
    }

    public function destroy(StatCounter $stat): RedirectResponse
    {
        $stat->delete();

        return redirect()
            ->route('admin.stats.index')
            ->with('status', 'Statistic deleted successfully.');
    }

    private function validatedStat(Request $request): array
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'value' => ['required', 'integer', 'min:0', 'max:9999999'],
            'prefix' => ['nullable', 'string', 'max:20'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'icon_label' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:300'],
            'accent' => ['required', Rule::in(['sky', 'teal', 'indigo', 'cyan', 'rose', 'pink', 'lavender', 'peach'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
