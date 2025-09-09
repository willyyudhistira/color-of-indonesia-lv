<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomeCarouselItem;
use App\Models\SponsorBanner;
use App\Models\MainEvent;
use App\Models\Testimonial;
use App\Models\Sponsor;
use App\Models\Photo;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil data Hero Carousel dari database
        $carouselItems = HomeCarouselItem::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 2. Buat objek untuk slide default
        $defaultSlide = (object) [
            'image_url'  => 'assets/images/home-hero.png',
            'alt_text'   => 'Color Of Indonesia',
            'subtitle'   => 'Through the culture we become one',
            'is_default' => true
        ];
        
        // 3. Tambahkan slide default ke AWAL koleksi carousel
        $carouselItems->prepend($defaultSlide);

        // 4. Kumpulkan semua data dinamis menjadi satu array
        $homeData = [
            'carousel'       => $carouselItems, 
            'sponsorBanners' => SponsorBanner::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            
          
            'mainEvents'     => MainEvent::latest()->take(4)->get(),

            'testimonials'   => Testimonial::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'sponsors'       => Sponsor::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
        ];
        
        // 5. Ambil gambar untuk section "Tentang Kami"
        $aboutImages = Photo::whereHas('album', function ($query) {
                $query->where('slug', 'tentang-kami');
            })
            ->where('is_published', true)
            ->inRandomOrder()
            ->get();
        
        // 6. Kirim semua data yang dibutuhkan ke view
        return view('pages.home', compact('homeData', 'aboutImages'));
    }
}