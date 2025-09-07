<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // --- SIMULASI DATA DARI DATABASE ---
       $allPhotos = [
            // PERHATIKAN 'ar=1:1' (aspect-ratio 1:1) di setiap URL
            ['id' => 1, 'album' => 'ASEAN Youth Camp', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ar=1:1&w=800&fit=crop'],
            ['id' => 2, 'album' => 'Festival Tari', 'image' => 'https://images.unsplash.com/photo-1542037104857-4bb4b9a35248?ar=1:1&w=800&fit=crop'],
            ['id' => 3, 'album' => 'Festival Tari', 'image' => 'https://images.unsplash.com/photo-1599882247019-322b7454b518?ar=1:1&w=800&fit=crop'],
            ['id' => 4, 'album' => 'Komunitas Lokal', 'image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?ar=1:1&w=800&fit=crop'],
            ['id' => 5, 'album' => 'ASEAN Youth Camp', 'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ar=1:1&w=800&fit=crop'],
            ['id' => 6, 'album' => 'Festival Tari', 'image' => 'https://images.unsplash.com/photo-1511795409837-091a56391d1a?ar=1:1&w=800&fit=crop'],
            ['id' => 7, 'album' => 'Komunitas Lokal', 'image' => 'https://images.unsplash.com/photo-1519340241574-2cec6a12a52d?ar=1:1&w=800&fit=crop'],
            ['id' => 8, 'album' => 'ASEAN Youth Camp', 'image' => 'https://images.unsplash.com/photo-1579626429272-c42475215b22?ar=1:1&w=800&fit=crop'],
            ['id' => 9, 'album' => 'Festival Tari', 'image' => 'https://images.unsplash.com/photo-1629018503899-c331575a6202?ar=1:1&w=800&fit=crop'],
            ['id' => 10, 'album' => 'Komunitas Lokal', 'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ar=1:1&w=800&fit=crop'],
            ['id' => 11, 'album' => 'ASEAN Youth Camp', 'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ar=1:1&w=800&fit=crop'],
            ['id' => 12, 'album' => 'Komunitas Lokal', 'image' => 'https://images.unsplash.com/photo-1511578194003-062818c14a29?ar=1:1&w=800&fit=crop'],
        ];

        $albums = ['Semua', 'ASEAN Youth Camp', 'Festival Tari', 'Komunitas Lokal'];
        // ------------------------------------

        $selectedAlbum = $request->query('album', 'Semua');

        // Filter foto berdasarkan album yang dipilih
        $filteredPhotos = collect($allPhotos);
        if ($selectedAlbum && $selectedAlbum !== 'Semua') {
            $filteredPhotos = $filteredPhotos->where('album', $selectedAlbum);
        }

        // Logika Pagination manual
        $perPage = 9; // Jumlah item per halaman
        $currentPage = $request->input('page', 1);
        $pagedData = $filteredPhotos->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedPhotos = new LengthAwarePaginator(
            $pagedData,
            $filteredPhotos->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pages.gallery', [
            'photos' => $paginatedPhotos,
            'albums' => $albums,
            'selectedAlbum' => $selectedAlbum
        ]);
    }
}
