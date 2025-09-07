<?php

namespace App\Http\Controllers\Web; // <-- Diperbaiki: Menggunakan backslash (\)

use App\Http\Controllers\Controller;
use App\Services\HomeService; // <-- Diperbaiki: Menggunakan backslash (\)

class HomeController extends Controller
{
    // Menggunakan property promotion (fitur PHP 8+) untuk dependency injection
    public function __construct(private HomeService $homeService)
    {
    }

    public function index()
    {
        // ===================================================================
        // DATA STATIS SEMENTARA (PENGGANTI DATA DARI ADMIN)
        // ===================================================================
        // Path gambar mengarah ke folder public/assets/images
        
        $homeData = [
            'carousel' => [
                ['id' => 1, 'image_url' => 'assets/images/hero-bg.png', 'alt_text' => 'Color Of Indonesia', 'subtitle' => 'Through the culture, We become One'],
                ['id' => 2, 'image_url' => 'assets/images/hero-bg.png', 'alt_text' => 'Keragaman Budaya', 'subtitle' => 'Menyatukan Nusantara dalam Seni'],
            ],
            'sponsorBanners' => [
                ['id' => 1, 'image_url' => 'assets/images/hero-bg.png'],
            ],
            'mainEvents' => [
                ['id' => 1, 'hero_image_url' => 'assets/images/eventhome.png', 'title' => 'Event IICF', 'subtitle' => 'Jakarta', 'description' => 'Deskripsi singkat tentang event IICF.'],
                ['id' => 2, 'hero_image_url' => 'assets/images/eventhome.png', 'title' => 'Event BIFF', 'subtitle' => 'Yogyakarta', 'description' => 'Deskripsi singkat tentang event BIFF.'],
                ['id' => 3, 'hero_image_url' => 'assets/images/eventhome.png', 'title' => 'Event APIFF', 'subtitle' => 'Solo', 'description' => 'Deskripsi singkat tentang event APIFF.'],
                ['id' => 4, 'hero_image_url' => 'assets/images/eventhome.png', 'title' => 'Event YIDC', 'subtitle' => 'Bandung', 'description' => 'Deskripsi singkat tentang event YIDC.'],
            ],
            'testimonials' => [
                ['id' => 1, 'avatar_url' => 'assets/images/EventsImg (1).png', 'quote' => 'Setiap event membawa Anda untuk menjelajah, belajar, dan terhubung dengan komunitas global.', 'author_name' => 'Sangat Penggiat'],
            ],
            'sponsors' => [
                ['id' => 1, 'name' => 'Sponsor A', 'logo_url' => 'assets/images/logo-sponsor.png'],
                ['id' => 2, 'name' => 'Sponsor B', 'logo_url' => 'assets/images/logo-sponsor.png'],
                ['id' => 3, 'name' => 'Sponsor C', 'logo_url' => 'assets/images/logo-sponsor.png'],
            ],
        ];

        // Data statis untuk gambar "Tentang Kami"
        $aboutImages = [
            ['id' => 1, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'large'],
            ['id' => 2, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'large'],
            ['id' => 3, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'small'],
            ['id' => 4, 'img' => 'assets/images/EventsImg (2).png', 'type' => 'small'],
        ];
        
        // Kirim data statis ini ke view
        return view('pages.home', [
            'homeData' => $homeData,
            'aboutImages' => $aboutImages,
        ]);
    }
}