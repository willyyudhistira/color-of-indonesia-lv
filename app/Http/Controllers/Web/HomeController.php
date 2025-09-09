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
        // 1. Ambil data carousel dari database
        $carouselItems = HomeCarouselItem::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();
            
        // 2. Buat slide default dan gabungkan. Ini opsional, bisa Anda hapus jika tidak perlu.
        $defaultSlide = (object) [
            'image_url'  => 'assets/images/home-hero.png',
            'alt_text'   => 'Color Of Indonesia<br><span class="font-light text-2xl md:text-3xl tracking-normal">Through the culture we become one</span>',
            'subtitle'   => '', // Subtitle sudah digabung di alt_text
            'is_default' => true
        ];
        $carouselItems->prepend($defaultSlide);

        // 3. Ambil sisa data untuk halaman utama
        $homeData = [
            'carousel'       => $carouselItems, 
            'sponsorBanners' => SponsorBanner::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'mainEvents'     => MainEvent::latest()->take(4)->get(),
            'testimonials'   => Testimonial::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
            'sponsors'       => Sponsor::where('is_published', true)->orderBy('sort_order', 'asc')->get(),
        ];
        
        // 4. Ambil SEMUA foto yang tersedia untuk animasi "Tentang Kami"
        $aboutImages = Photo::where('is_published', true)
                          ->whereHas('album', fn($query) => $query->where('is_published', true))
                          ->inRandomOrder() // Acak urutannya dari database
                          ->get();
        
        // 5. Kirim semua data ke view
        return view('pages.home', compact('homeData', 'aboutImages'));
    }
}