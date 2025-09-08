<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Event; // Pastikan model Event sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str facade untuk membuat slug

class EventController extends Controller
{
    /**
     * Menampilkan daftar event dengan paginasi.
     */
    public function index()
    {
        $events = Event::latest('start_date')->paginate(10); // Urutkan & paginasi
        return view('admin.events.index', ['events' => $events]);
    }

    /**
     * Menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        return view('admin.events.create');
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
        ], [
            'title.unique' => 'Judul event ini sudah pernah digunakan. Silakan gunakan judul lain.'
        ]);

        // Buat slug secara otomatis
        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->hasFile('hero_image_url')) {
            $validated['hero_image_url'] = $request->file('hero_image_url')->store('event_heroes', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event]);
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
        ]);
        
        if ($request->hasFile('hero_image_url')) {
            if ($event->hero_image_url) {
                Storage::disk('public')->delete($event->hero_image_url);
            }
            $validated['hero_image_url'] = $request->file('hero_image_url')->store('event_heroes', 'public');
        }
        
        $event->update($validated);
        
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
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

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}