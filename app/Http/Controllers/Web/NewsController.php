<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NewsLink; // <-- Import model NewsLink
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Ambil data dari database menggunakan model NewsLink
        // - Hanya tampilkan berita yang 'is_published' = true
        // - Urutkan berdasarkan tanggal publikasi terbaru
        // - Lakukan paginasi, 3 item per halaman
        $newsItems = NewsLink::where('is_published', true)
                            ->orderBy('published_at', 'desc')
                            ->paginate(3);
        
        // Kirim data yang sudah dipaginasi ke view
        return view('pages.news', ['newsItems' => $newsItems]);
    }
}