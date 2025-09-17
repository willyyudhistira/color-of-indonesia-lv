<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
{
    $upcomingEvents = Event::where('is_published', true)
                           ->where('start_date', '>=', Carbon::now())
                           ->orderBy('start_date', 'asc')
                           ->get();

    $pastEventsQuery = Event::where('is_published', true)
                            ->where('start_date', '<', Carbon::now());

    $selectedMonth = null;

    // Kembali menggunakan filter 'month' dengan format YYYY-MM
    if ($request->has('month') && $request->filled('month')) {
        try {
            $filterDate = Carbon::createFromFormat('Y-m', $request->month);
            $pastEventsQuery->whereMonth('start_date', $filterDate->month)
                            ->whereYear('start_date', $filterDate->year);
            $selectedMonth = $filterDate;
        } catch (\Exception $e) {
            // Abaikan
        }
    }

    $pastEvents = $pastEventsQuery->orderBy('start_date', 'desc')->paginate(6);
    $pastEvents->appends($request->query());

    return view('pages.events', [
        'upcomingEvents' => $upcomingEvents,
        'events' => $pastEvents,
        'selectedMonth' => $selectedMonth,
    ]);
}
    
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        return view('pages.event-detail', [
            'event' => $event
        ]);
    }
}