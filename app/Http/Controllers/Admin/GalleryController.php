<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar album di admin panel.
     */
    public function index()
    {
        // Ganti nama variabel kembali menjadi 'albums'
        $albums = Album::withCount('photos')->orderBy('sort_order', 'asc')->get();
        return view('admin.gallery.index', ['albums' => $albums]); // Sekarang dikirim sebagai 'albums'
    }

    /**
     * Menampilkan form untuk membuat album baru.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Menyimpan album baru.
     */
    public function store(Request $request)
    {
        // ## TAMBAHKAN BARIS INI UNTUK MEMPERBAIKI CHECKBOX ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean', // Diubah menjadi required
        ]);

        if ($request->hasFile('cover_url')) {
            $validated['cover_url'] = $request->file('cover_url')->store('album_covers', 'public');
        }
        
        Album::create($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Album berhasil dibuat.');
    }

    /**
     * Menampilkan halaman untuk mengelola foto dalam satu album (upload & statistik).
     */
    public function show(Album $gallery) // <-- UBAH $album menjadi $gallery
    {
        $gallery->load('photos');
        $stats = ['total' => $gallery->photos->count()];

        return view('admin.gallery.show', [
            'album' => $gallery, // <-- Kirim dengan nama 'album' agar view tidak error
            'stats' => $stats
        ]);
    }

    /**
     * Menampilkan form untuk mengedit album.
     */
    public function edit(Album $gallery) // <-- UBAH $album menjadi $gallery
    {
        return view('admin.gallery.edit', ['album' => $gallery]); // <-- Kirim dengan nama 'album'
    }

    /**
     * Mengupdate data album.
     */
    public function update(Request $request, Album $gallery)
    {
        // ## TAMBAHKAN BARIS INI JUGA DI SINI ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);
        
        if ($request->hasFile('cover_url')) {
            if($gallery->cover_url){
                Storage::disk('public')->delete($gallery->cover_url);
            }
            $validated['cover_url'] = $request->file('cover_url')->store('album_covers', 'public');
        }

        $gallery->update($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Album berhasil diperbarui.');
    }
    
    /**
     * Menghapus album.
     */
    public function destroy(Album $gallery)
    {
        // Logika hapus album & foto-fotonya di storage
        // ...
        return redirect()->route('admin.gallery.index')->with('success', 'Album berhasil dihapus.');
    }
    
    /**
     * Method baru untuk upload foto ke dalam album.
     */
    public function uploadPhoto(Request $request, Album $gallery)
    {
        $request->validate([
            'photo' => 'required|image|max:4096',
            'caption' => 'nullable|string|max:150',
        ]);

        $path = $request->file('photo')->store('gallery_photos', 'public');

        $gallery->photos()->create([
            'image_url' => $path,
            'caption' => $request->caption,
            'sort_order' => $gallery->photos()->count() + 1,
        ]);

        return back()->with('success', 'Foto berhasil di-upload.');
    }
    
    /**
     * Method baru untuk menghapus foto.
     */
    public function destroyPhoto(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image_url);
        $photo->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}