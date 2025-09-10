<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;

class GalleryController extends Controller
{
    /**
     * Menampilkan HALAMAN DAFTAR ALBUM.
     */
    public function index()
    {
        $albums = Album::where('is_published', true)
                       ->withCount('photos') // Menghitung jumlah foto
                       ->orderBy('sort_order', 'asc')
                       ->paginate(9); // 9 album per halaman

        return view('pages.gallery.index', ['albums' => $albums]);
    }

    /**
     * Menampilkan HALAMAN DETAIL ALBUM (berisi foto-foto).
     */
    public function show(Album $album) // Menggunakan Route-Model Binding
    {
        abort_if(!$album->is_published, 404);

        $photos = $album->photos()
                        ->where('is_published', true)
                        ->orderBy('sort_order', 'asc')
                        ->paginate(12); // 12 foto per halaman

        return view('pages.gallery.show', [
            'album' => $album,
            'photos' => $photos
        ]);
    }
}