<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar semua album.
     */
    public function index()
    {
        $albums = Album::withCount('photos')->orderBy('sort_order', 'asc')->get();
        return view('admin.gallery.index', ['albums' => $albums]);
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
        $request->merge(['is_published' => $request->has('is_published')]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);

        // 2. TAMBAHKAN LOGIKA UNTUK MEMBUAT SLUG
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_url')) {
            $validated['cover_url'] = $request->file('cover_url')->store('album_covers', 'public');
        }
        
        Album::create($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Album has been successfully added');
    }

    /**
     * Menampilkan halaman untuk mengelola foto dalam satu album.
     */
    public function show(Album $gallery)
    {
        $gallery->load('photos');
        $stats = ['total' => $gallery->photos->count()];

        return view('admin.gallery.show', [
            'album' => $gallery,
            'stats' => $stats
        ]);
    }

    /**
     * Menampilkan form untuk mengedit album.
     */
    public function edit(Album $gallery)
    {
        return view('admin.gallery.edit', ['album' => $gallery]);
    }

    /**
     * Mengupdate data album.
     */
    public function update(Request $request, Album $gallery)
    {
        $request->merge(['is_published' => $request->has('is_published')]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            // Pastikan slug unik, kecuali untuk dirinya sendiri
            'slug' => 'nullable|string|max:255|unique:albums,slug,' . $gallery->id,
            'description' => 'nullable|string',
            'cover_url' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);
        
        // 3. TAMBAHKAN LOGIKA UNTUK MEMBUAT SLUG SAAT UPDATE
        $validated['slug'] = Str::slug($validated['title']);
        
        if ($request->hasFile('cover_url')) {
            if($gallery->cover_url){
                Storage::disk('public')->delete($gallery->cover_url);
            }
            $validated['cover_url'] = $request->file('cover_url')->store('album_covers', 'public');
        }

        $gallery->update($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Album has been successfully updated.');
    }
    
    /**
     * Menghapus album.
     */
    public function destroy(Album $gallery)
    {
        // Hapus semua foto terkait di storage
        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->image_url);
        }
        // Hapus gambar sampul
        if ($gallery->cover_url) {
            Storage::disk('public')->delete($gallery->cover_url);
        }
        $gallery->delete(); // Ini akan menghapus record album dan foto-fotonya karena relasi cascade
        return redirect()->route('admin.gallery.index')->with('success', 'Album has been successfully deleted.');
    }
    
    /**
     * Method untuk upload foto ke dalam album.
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

        return back()->with('success', 'Photo has been successfully uploaded.');
    }
    
    /**
     * Method untuk menghapus foto.
     */
    public function destroyPhoto(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image_url);
        $photo->delete();
        return back()->with('success', 'Photo has been successfully deleted.');
    }
}