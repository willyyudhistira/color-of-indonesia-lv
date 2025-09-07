<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
// use App.Models.Event; // Hapus komentar ini saat Anda sudah punya model Event

class EventController extends Controller
{
    /**
     * Menampilkan halaman DAFTAR event dengan pagination.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua data event dari satu sumber terpusat.
        $allEventsData = $this->getDummyEvents();

        // 2. Pisahkan antara event mendatang dan event lainnya.
        // Di sini kita akan mengambil SEMUA event mendatang, bukan hanya satu.
        $upcomingEvents = collect($allEventsData)->where('upcoming', true);
        $otherEvents = collect($allEventsData)->where('upcoming', false);

        // 3. Siapkan pagination untuk event lainnya.
        $perPage = 6;
        $currentPage = $request->input('page', 1);
        $pagedData = $otherEvents->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedEvents = new LengthAwarePaginator(
            $pagedData,
            $otherEvents->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // 4. Kirim data ke view.
        return view('pages.events', [
            'upcomingEvent' => $upcomingEvents->first(), // Tetap kirim satu event untuk card utama
            'events' => $paginatedEvents
        ]);
    }

    /**
     * Menampilkan halaman DETAIL event.
     */
    public function show($slug)
    {
        // 1. Ambil semua data dari sumber yang sama.
        $allEventsData = $this->getDummyEvents();
        
        // 2. Cari event yang cocok berdasarkan slug.
        $event = collect($allEventsData)->firstWhere('slug', $slug);

        // 3. Jika tidak ditemukan, tampilkan halaman 404 (Not Found).
        abort_if(!$event, 404);

        // 4. Kirim data event yang ditemukan ke view.
        return view('pages.event-detail', [
            'event' => $event
        ]);
    }

    /**
     * SATU-SATUNYA SUMBER DATA DUMMY
     * Semua data event untuk controller ini berasal dari sini untuk menjaga konsistensi.
     */
    private function getDummyEvents()
    {
        return [
            // Event Mendatang (Upcoming)
            ['id' => 1, 'title' => 'Indonesia International Culture Festival 2025', 'slug' => 'indonesia-international-culture-festival-2025', 'location' => 'Taman Mini Indonesia Indah', 'date' => '2025-10-28', 'image' => asset('assets/images/EventsImg (1).png'), 'description' => '<p>Deskripsi lengkap tentang festival budaya internasional yang meriah...</p>', 'start_date' => '2025-10-28', 'end_date' => '2025-10-30', 'location_name' => 'Taman Mini Indonesia Indah', 'address' => 'Jl. Taman Mini Indonesia Indah, Ceger, Cipayung', 'hero_image_url' => 'https://images.unsplash.com/photo-1542037104857-4bb4b9a35248?w=1200', 'form_url' => '/sponsorship', 'upcoming' => true],
            ['id' => 4, 'title' => 'Yogya International Dance Culture', 'slug' => 'yogya-international-dance-culture', 'location' => 'Candi Prambanan', 'date' => '2025-12-05', 'image' => asset('assets/images/EventsImg (4).png'), 'description' => '<p>Deskripsi untuk Yogya International Dance Culture...</p>', 'start_date' => '2025-12-05', 'end_date' => '2025-12-07', 'location_name' => 'Candi Prambanan', 'address' => 'Jl. Raya Solo - Yogyakarta No.16', 'hero_image_url' => 'https://images.unsplash.com/photo-1599882247019-322b7454b518?w=1200', 'form_url' => '/sponsorship', 'upcoming' => true],
            ['id' => 5, 'title' => 'Jakarta World Music Festival', 'slug' => 'jakarta-world-music-festival', 'location' => 'GBK, Jakarta', 'date' => '2026-01-10', 'image' => asset('assets/images/EventsImg (1).png'), 'description' => '<p>Deskripsi untuk Jakarta World Music Festival...</p>', 'start_date' => '2026-01-10', 'end_date' => '2026-01-12', 'location_name' => 'GBK, Jakarta', 'address' => 'Gelora Bung Karno, Jakarta Pusat', 'hero_image_url' => 'https://images.unsplash.com/photo-1516942459092-162b4c19c9aa?w=1200', 'form_url' => '/sponsorship', 'upcoming' => true],
            
            // Event Lainnya (Telah Lewat)
            ['id' => 2, 'title' => 'Bali International Folklore Festival 2025', 'slug' => 'bali-international-folklore-festival-2025', 'location' => 'Ubud, Bali', 'date' => '2025-11-15', 'image' => asset('assets/images/EventsImg (2).png'), 'description' => '<p>Menampilkan tarian dan musik tradisional dari seluruh dunia di jantung budaya Bali...</p>', 'start_date' => '2024-11-15', 'end_date' => '2024-11-17', 'location_name' => 'Ubud, Bali', 'address' => 'Jl. Raya Ubud, Gianyar, Bali', 'hero_image_url' => 'https://images.unsplash.com/photo-1537953773345-d172ccfa1380?w=1200', 'form_url' => '#', 'upcoming' => false],
            ['id' => 3, 'title' => 'Adventure Pinrang International Folklore', 'slug' => 'adventure-pinrang-international-folklore', 'location' => 'Pinrang, Sulawesi', 'date' => '2025-11-20', 'image' => asset('assets/images/EventsImg (3).png'), 'description' => '<p>Sebuah perayaan unik yang menggabungkan petualangan alam dan pertunjukan folklor...</p>', 'start_date' => '2024-11-20', 'end_date' => '2024-11-22', 'location_name' => 'Pinrang, Sulawesi', 'address' => 'Kabupaten Pinrang, Sulawesi Selatan', 'hero_image_url' => 'https://images.unsplash.com/photo-1629018503899-c331575a6202?w=1200', 'form_url' => '#', 'upcoming' => false],
            ['id' => 6, 'title' => 'Borobudur International Arts & Performance', 'slug' => 'borobudur-international-arts-performance', 'location' => 'Candi Borobudur', 'date' => '2026-02-22', 'image' => asset('assets/images/EventsImg (2).png'), 'description' => '<p>Deskripsi untuk Borobudur International Arts & Performance...</p>', 'start_date' => '2024-02-22', 'end_date' => '2024-02-24', 'location_name' => 'Candi Borobudur', 'address' => 'Jl. Badrawati, Kw. Candi Borobudur', 'hero_image_url' => 'https://images.unsplash.com/photo-1596708235235-989b4f90a424?w=1200', 'form_url' => '#', 'upcoming' => false],
            ['id' => 7, 'title' => 'Solo International Performing Arts', 'slug' => 'solo-international-performing-arts', 'location' => 'Benteng Vastenburg', 'date' => '2026-03-18', 'image' => asset('assets/images/EventsImg (3).png'), 'description' => '<p>Deskripsi untuk Solo International Performing Arts...</p>', 'start_date' => '2024-03-18', 'end_date' => '2024-03-20', 'location_name' => 'Benteng Vastenburg', 'address' => 'Jl. Mayor Sunaryo, Kedung Lumbu', 'hero_image_url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1200', 'form_url' => '#', 'upcoming' => false],
        ];
    }
}