<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo; // <-- Pastikan model Photo di-import

class GalleryController extends Controller
{
    /**
     * Menampilkan halaman galeri publik.
     * Menerima parameter Album opsional untuk filtering.
     */
    public function index(Album $album = null)
    {
        // 1. Ambil SEMUA album untuk ditampilkan di dropdown filter
        $allAlbums = Album::where('is_published', true)->orderBy('sort_order', 'asc')->get();

        // 2. Tentukan judul yang dipilih untuk ditampilkan di tombol dropdown
        $selectedAlbumName = $album ? $album->title : 'Semua Album';

        // 3. Ambil foto berdasarkan album yang dipilih (atau semua foto jika tidak ada album yang dipilih)
        if ($album) {
            // Jika album dipilih, ambil foto dari album tersebut
            $photos = $album->photos()->where('is_published', true)->paginate(9);
        } else {
            // Jika tidak ada album dipilih, ambil semua foto dari semua album yang published
            $photos = Photo::where('is_published', true)
                ->whereHas('album', fn($query) => $query->where('is_published', true))
                ->latest()
                ->paginate(9);
        }

        // 4. Kirim semua data yang diperlukan ke view
        return view('pages.gallery', [
            'photos' => $photos,
            'albums' => $allAlbums,
            'selectedAlbumName' => $selectedAlbumName, // <-- Variabel ini yang dibutuhkan oleh view
        ]);
    }
}