<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;

class GalleryController extends Controller
{
    /**
     * Menampilkan halaman galeri, secara otomatis memfilter berdasarkan album dari URL.
     */
    public function index(Album $album = null)
    {
        // 1. Ambil SEMUA album yang published untuk ditampilkan di dropdown filter
        $allAlbums = Album::where('is_published', true)->orderBy('sort_order', 'asc')->get();

        // 2. Tentukan judul yang dipilih berdasarkan ada atau tidaknya $album dari URL
        $selectedAlbumName = $album ? $album->title : 'Semua Album';

        // 3. Ambil foto berdasarkan kondisi
        if ($album) {
            // Jika $album ada (ditemukan dari URL), ambil foto HANYA dari album tersebut
            $photos = $album->photos()
                            ->where('is_published', true)
                            ->latest()
                            ->paginate(12);
        } else {
            // Jika tidak ada album di URL, ambil semua foto dari semua album yang published
            $photos = Photo::where('is_published', true)
                           ->whereHas('album', fn($query) => $query->where('is_published', true))
                           ->latest()
                           ->paginate(12);
        }

        // 4. Kirim semua data yang diperlukan ke view
        return view('pages.gallery', [
            'photos' => $photos,
            'albums' => $allAlbums,
            'selectedAlbumName' => $selectedAlbumName,
        ]);
    }
}