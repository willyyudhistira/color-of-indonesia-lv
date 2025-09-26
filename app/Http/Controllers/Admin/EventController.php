<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\Event; // Pastikan model Event sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str facade untuk membuat slug
use Carbon\Carbon;
use App\Exports\EventsReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Participant;

class EventController extends Controller
{
    /**
     * Menampilkan daftar event dengan paginasi.
     */
    public function index(Request $request) // 2. Tambahkan Request $request
    {
        // Logika untuk kartu ringkasan (tidak berubah)
        $pastEventsCount = Event::where('start_date', '<', Carbon::now())->count();
        $upcomingEventsCount = Event::where('start_date', '>=', Carbon::now())->count();

        // 3. Siapkan query dasar untuk daftar event
        $eventsQuery = Event::query();

        // 4. Terapkan filter bulan jika ada di URL
        if ($request->has('month') && $request->filled('month')) {
            try {
                $filterDate = Carbon::createFromFormat('Y-m', $request->month);
                $eventsQuery->whereMonth('start_date', $filterDate->month)
                    ->whereYear('start_date', $filterDate->year);
            } catch (\Exception $e) {
                // Abaikan jika format bulan tidak valid
            }
        }

        // 5. Eksekusi query dengan urutan dan paginasi
        $events = $eventsQuery->latest('start_date')->paginate(10);

        // 6. Tambahkan filter ke link pagination
        $events->appends($request->query());

        // Kirim semua data ke view
        return view('admin.events.index', [
            'events' => $events,
            'pastEventsCount' => $pastEventsCount,
            'upcomingEventsCount' => $upcomingEventsCount,
        ]);
    }

    /**
     * Menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        $templates = CertificateTemplate::orderBy('template_name')->get();
        return view('admin.events.create', compact('templates'));
    }

    /**
     * Menyimpan event baru.
     */
    public function store(Request $request)
    {
        // ## TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI CHECKBOX ##
        $request->merge([
            'is_featured' => $request->has('is_featured'),
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:150|unique:event_scheduled,title',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'form_url' => 'required|url',
            'hero_image_url' => 'nullable|image|max:4096',
            'is_featured' => 'required|boolean', // Diubah menjadi required
            'is_published' => 'required|boolean', // Diubah menjadi required
            'certificate_template_id' => 'nullable|exists:certificate_templates,id',
        ], [
            'title.unique' => 'This event title has already been used. Please use a different title.'
        ]);

        // Buat slug secara otomatis
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('hero_image_url')) {
            $validated['hero_image_url'] = $request->file('hero_image_url')->store('event_heroes', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event has been successfully added.');
    }

    /**
     * Menampilkan form untuk mengedit event.
     */
    public function edit(Event $event)
    {
        $templates = CertificateTemplate::orderBy('template_name')->get();
        return view('admin.events.edit', compact('event', 'templates'));
    }

    /**
     * Memperbarui event yang ada.
     */
    public function update(Request $request, Event $event)
    {
        // ## TAMBAHKAN BLOK INI JUGA DI SINI ##
        $request->merge([
            'is_featured' => $request->has('is_featured'),
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:160|unique:event_scheduled,slug,' . $event->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'form_url' => 'required|url',
            'hero_image_url' => 'nullable|image|max:4096',
            'is_featured' => 'required|boolean', // Diubah menjadi required
            'is_published' => 'required|boolean', // Diubah menjadi required
            'certificate_template_id' => 'nullable|exists:certificate_templates,id',
        ]);

        if ($request->hasFile('hero_image_url')) {
            if ($event->hero_image_url) {
                Storage::disk('public')->delete($event->hero_image_url);
            }
            $validated['hero_image_url'] = $request->file('hero_image_url')->store('event_heroes', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event has been successfully updated.');
    }

    /**
     * Menghapus event.
     */
    public function destroy(Event $event)
    {
        if ($event->hero_image_url) {
            Storage::disk('public')->delete($event->hero_image_url);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event has been successfully deleted.');
    }

    // Eksport report
    public function export()
    {
        // Menentukan nama file yang akan diunduh
        $fileName = 'events_report_' . date('Y-m-d') . '.xlsx';

        // Memulai proses download
        return Excel::download(new EventsReportExport, $fileName);
    }
}