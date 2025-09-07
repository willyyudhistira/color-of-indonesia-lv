<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $upcomingEvents = Event::where('is_published', true)
                               ->whereDate('start_date', '>=', $today)
                               ->orderBy('start_date', 'asc')
                               ->get();

        $pastEvents = Event::where('is_published', true)
                           ->whereDate('start_date', '<', $today)
                           ->orderBy('start_date', 'desc')
                           ->paginate(6);

        return view('pages.events', [
            'upcomingEvent' => $upcomingEvents->first(),
            'otherUpcomingEvents' => $upcomingEvents->slice(1), 
            'events' => $pastEvents,
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