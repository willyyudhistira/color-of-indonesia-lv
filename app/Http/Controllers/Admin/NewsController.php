<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLink; // Pastikan model NewsLink sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita dengan paginasi.
     */
    public function index()
    {
        $newsItems = NewsLink::latest('published_at')->paginate(10);
        return view('admin.news.index', ['newsItems' => $newsItems]);
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Menyimpan berita baru.
     */
    public function store(Request $request)
    {
        // ## TAMBAHKAN BARIS INI UNTUK MEMPERBAIKI CHECKBOX ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:500',
            'source_name' => 'required|string|max:120',
            'source_url' => 'required|url',
            'image_url' => 'required|image|max:2048',
            'published_at' => 'required|date',
            'is_published' => 'required|boolean', // Diubah menjadi required
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('news_images', 'public');
        }

        NewsLink::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Artikel berita berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(NewsLink $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    /**
     * Memperbarui berita yang ada.
     */
    public function update(Request $request, NewsLink $news)
    {
        // ## TAMBAHKAN BARIS INI JUGA DI SINI ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:160',
            'excerpt' => 'nullable|string|max:500',
            'source_name' => 'nullable|string|max:120',
            'source_url' => 'required|url',
            'image_url' => 'nullable|image|max:2048',
            'published_at' => 'required|date',
            'is_published' => 'required|boolean', // Diubah menjadi required
        ]);
        
        if ($request->hasFile('image_url')) {
            if ($news->image_url) {
                Storage::disk('public')->delete($news->image_url);
            }
            $validated['image_url'] = $request->file('image_url')->store('news_images', 'public');
        }
        
        $news->update($validated);
        
        return redirect()->route('admin.news.index')->with('success', 'Artikel berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita.
     */
    public function destroy(NewsLink $news)
    {
        if ($news->image_url) {
            Storage::disk('public')->delete($news->image_url);
        }
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Artikel berita berhasil dihapus.');
    }
}