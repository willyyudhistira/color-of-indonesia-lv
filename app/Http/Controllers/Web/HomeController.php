<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
// Import semua model yang dibutuhkan untuk halaman utama
use App\Models\HomeCarouselItem;
use App\Models\SponsorBanner;
use App\Models\MainEvent;
use App\Models\Testimonial;
use App\Models\Sponsor;
use App\Models\Photo;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     * Semua data diambil langsung dari database.
     */
    public function index()
    {
        // 1. Ambil data Hero Carousel
        // Hanya yang berstatus 'published', diurutkan berdasarkan 'sort_order'
        $carouselItems = HomeCarouselItem::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 2. Ambil data Sponsor Banner
        $sponsorBanners = SponsorBanner::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 3. Ambil data Main Events (jika ada lebih dari satu, kita ambil semua)
        $mainEvents = MainEvent::latest()->get();

        // 4. Ambil data Testimonial
        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 5. Ambil data Sponsor (logo)
        $sponsors = Sponsor::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 6. Kumpulkan semua data dinamis menjadi satu array
        $homeData = [
            'carousel' => HomeCarouselItem::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'sponsorBanners' => SponsorBanner::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'mainEvents' => MainEvent::latest()->get(),
            'testimonials' => Testimonial::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'sponsors' => Sponsor::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
        ];
        
        // 7. Kirim data yang sudah diambil dari database ke view
        // return view('pages.home', [
        //     'homeData' => $homeData,
        //     // Anda bisa tetap menggunakan data statis untuk gambar 'Tentang Kami' jika belum ada di database
        //     'aboutImages' => [
        //         ['id' => 1, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'large'],
        //         ['id' => 2, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'large'],
        //         ['id' => 3, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'small'],
        //         ['id' => 4, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'small'],
        //     ]
        // ]);

        // ## LOGIKA BARU UNTUK GAMBAR "TENTANG KAMI" ##
        
        $aboutImages = Photo::where('is_published', true)
                          ->whereHas('album', fn($query) => $query->where('is_published', true))
                          ->get();
        
        return view('pages.home', [
            'homeData' => $homeData,
            'aboutImages' => $aboutImages, // Kirim semua foto ke view
        ]);
    }
}