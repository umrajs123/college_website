<?php

namespace App\Http\Controllers;

use App\Models\CampusEvent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = trim((string) $request->input('category', ''));
        $selectedMonth = trim((string) $request->input('month', ''));

        $eventsQuery = CampusEvent::active()->orderBy('starts_at')->orderBy('sort_order');

        if ($selectedCategory !== '') {
            $eventsQuery->where('category', $selectedCategory);
        }

        if ($selectedMonth !== '' && preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            [$year, $month] = explode('-', $selectedMonth);
            $eventsQuery->whereYear('starts_at', $year)->whereMonth('starts_at', $month);
        }

        return view('events.index', [
            'events' => $eventsQuery->paginate(6)->withQueryString(),
            'categories' => CampusEvent::active()->select('category')->distinct()->orderBy('category')->pluck('category')->filter()->values(),
            'months' => $this->availableMonths(),
            'selectedCategory' => $selectedCategory,
            'selectedMonth' => $selectedMonth,
        ]);
    }

    private function availableMonths()
    {
        return CampusEvent::active()
            ->orderBy('starts_at')
            ->get(['starts_at'])
            ->map(fn (CampusEvent $event) => [
                'value' => $event->starts_at->format('Y-m'),
                'label' => $event->starts_at->format('F Y'),
            ])
            ->unique('value')
            ->values();
    }
}
