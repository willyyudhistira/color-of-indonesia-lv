<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil SEMUA event mendatang dari database (TIDAK BERUBAH)
        $upcomingEvents = Event::where('is_published', true)
                               ->where('start_date', '>=', Carbon::now())
                               ->orderBy('start_date', 'asc')
                               ->get();

        // 2. Ambil event yang sudah lewat dengan PAGINATION (TIDAK BERUBAH)
        $pastEvents = Event::where('is_published', true)
                           ->where('start_date', '<', Carbon::now())
                           ->orderBy('start_date', 'desc')
                           ->paginate(6);

        // 3. PERUBAHAN: Kirim seluruh koleksi '$upcomingEvents' ke view
        return view('pages.events', [
            'upcomingEvents' => $upcomingEvents, // Diubah dari 'upcomingEvent'
            'events' => $pastEvents
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