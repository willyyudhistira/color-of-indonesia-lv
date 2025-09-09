<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainEventController extends Controller
{
    /**
     * Menampilkan daftar semua main event.
     */
    public function index()
    {
        $mainEvents = MainEvent::latest()->get();
        return view('admin.main_event.index', ['mainEvents' => $mainEvents]);
    }

    /**
     * Menampilkan form untuk membuat main event baru.
     */
    public function create()
    {
        return view('admin.main_event.create');
    }

    /**
     * Menyimpan main event baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'required|string',
            'description' => 'nullable|string',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'hero_image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['hero_image_url'] = $request->file('hero_image_url')->store('main_event_hero', 'public');
        MainEvent::create($validated);

        return redirect()->route('admin.main-events.index')->with('success', 'Main Event berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit main event.
     */
    public function edit(MainEvent $mainEvent)
    {
        return view('admin.main_event.edit', ['mainEvent' => $mainEvent]);
    }

    /**
     * Memperbarui main event yang ada.
     */
    public function update(Request $request, MainEvent $mainEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'required|string',
            'description' => 'nullable|string',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'hero_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('hero_image_url')) {
            if ($mainEvent->hero_image_url) {
                Storage::disk('public')->delete($mainEvent->hero_image_url);
            }
            $validated['hero_image_url'] = $request->file('hero_image_url')->store('main_event_hero', 'public');
        }
        
        $mainEvent->update($validated);

        return redirect()->route('admin.main-events.index')->with('success', 'Main Event berhasil diperbarui.');
    }

    /**
     * Menghapus main event.
     */
    public function destroy(MainEvent $mainEvent)
    {
        if ($mainEvent->hero_image_url) {
            Storage::disk('public')->delete($mainEvent->hero_image_url);
        }
        $mainEvent->delete();

        return redirect()->route('admin.main-events.index')->with('success', 'Main Event berhasil dihapus.');
    }
}