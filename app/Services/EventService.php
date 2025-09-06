<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventService
{
    /**
     * Mendapatkan data event yang sudah dipublikasi dengan paginasi.
     */
    public function getPublicEvents(int $perPage = 10): LengthAwarePaginator
    {
        return Event::where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Mendapatkan semua data event dengan paginasi (untuk admin).
     */
    public function getAllEventsAdmin(int $perPage = 10): LengthAwarePaginator
    {
        return Event::orderBy('start_date', 'desc')->paginate($perPage);
    }

    /**
     * Membuat event baru.
     */
    public function createEvent(array $data): Event
    {
        if (isset($data['hero_image_url'])) {
            $path = $data['hero_image_url']->store('event_heroes', 'public');
            $data['hero_image_url'] = $path;
        }

        // Generate slug dari judul
        $data['slug'] = Str::slug($data['title']);
        // (Opsional) Tambahkan logika untuk memastikan slug unik jika diperlukan

        return Event::create($data);
    }

    /**
     * Memperbarui data event.
     */
    public function updateEvent(Event $event, array $data): Event
    {
        if (isset($data['hero_image_url'])) {
            // Hapus gambar lama jika ada
            if ($event->hero_image_url) {
                Storage::disk('public')->delete($event->hero_image_url);
            }
            $path = $data['hero_image_url']->store('event_heroes', 'public');
            $data['hero_image_url'] = $path;
        }
        
        // Generate ulang slug jika judul berubah
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $event->update($data);
        return $event;
    }

    /**
     * Menghapus event.
     */
    public function deleteEvent(Event $event): void
    {
        if ($event->hero_image_url) {
            Storage::disk('public')->delete($event->hero_image_url);
        }
        $event->delete();
    }
}