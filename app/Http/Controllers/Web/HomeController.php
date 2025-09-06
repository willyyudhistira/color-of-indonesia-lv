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
        // Panggil method dari service secara langsung
        // Diperbaiki: Menggunakan $this->homeService
        $homeData = $this->homeService->fetchHomePageData();
        
        // Data statis untuk gambar "Tentang Kami" yang ada di frontend
        $aboutImages = [
            ['id' => 1, 'img' => 'assets/images/about-img-1.jpg', 'type' => 'large'],
            ['id' => 2, 'img' => 'assets/images/about-img-2.jpg', 'type' => 'large'],
            ['id' => 3, 'img' => 'assets/images/about-img-3.jpg', 'type' => 'small'],
            ['id' => 4, 'img' => 'assets/images/about-img-4.jpg', 'type' => 'small'],
        ];

        // Kirim data ke view
        return view('pages.home', [
            'homeData' => $homeData,
            'aboutImages' => $aboutImages,
        ]);
    }
}