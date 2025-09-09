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
        
        // Ambil SEMUA event mendatang yang published
        $upcomingEvents = Event::where('is_published', true)
                               ->whereDate('start_date', '>=', $today)
                               ->orderBy('start_date', 'asc')
                               ->get();

        // Ambil SEMUA event yang telah lewat, bukan lagi di-paginate
        $pastEvents = Event::where('is_published', true)
                           ->whereDate('start_date', '<', $today)
                           ->orderBy('start_date', 'desc')
                           ->paginate(6); // <-- Diubah dari paginate() menjadi get()

        return view('pages.events', [
            'upcomingEvents' => $upcomingEvents, // Kirim seluruh koleksi upcoming events
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