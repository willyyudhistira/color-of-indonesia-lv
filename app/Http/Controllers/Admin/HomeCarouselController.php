<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCarouselItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeCarouselController extends Controller
{
    private const MAX_ITEMS = 4;

    /**
     * Menampilkan halaman utama manajemen carousel.
     */
    public function index()
    {
        $carouselItems = HomeCarouselItem::orderBy('sort_order', 'asc')->get();
        return view('admin.home.index', [
            'carouselItems' => $carouselItems,
            'maxItems' => self::MAX_ITEMS,
        ]);
    }

    /**
     * Menyimpan item carousel baru.
     */
    public function store(Request $request)
    {
        if (HomeCarouselItem::count() >= self::MAX_ITEMS) {
            return back()->with('error', 'Jumlah item carousel sudah maksimal.');
        }

        $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
        ]);

        $path = $request->file('image_url')->store('carousel_images', 'public');

        HomeCarouselItem::create([
            'image_url' => $path,
            'alt_text' => $request->alt_text ?? 'Gambar Carousel',
            'sort_order' => HomeCarouselItem::count() + 1,
            'is_published' => $request->boolean('is_published', true),
            'link_url' => $request->link_url,
        ]);

        // ## UBAH BARIS INI ##
        return redirect()->route('admin.dashboard')->with('success', 'Item carousel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit item.
     */
    public function edit(HomeCarouselItem $item)
    {
        return view('admin.home.edit', ['item' => $item]);
    }

    /**
     * Memperbarui item carousel.
     */
    public function update(Request $request, HomeCarouselItem $item)
    {
        // ## TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI CHECKBOX ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
            'is_published' => 'required|boolean', // Diubah menjadi required
            'sort_order' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image_url')) {
            if ($item->image_url) {
                Storage::disk('public')->delete($item->image_url);
            }
            $validated['image_url'] = $request->file('image_url')->store('carousel_images', 'public');
        }

        $item->update($validated);
        
        $this->reorderItems($item, $validated['sort_order']);
        
        return redirect()->route('admin.dashboard')->with('info', 'Item carousel berhasil diperbarui.');
    }

    /**
     * Menghapus item carousel.
     */
    public function destroy(HomeCarouselItem $item)
    {
        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }
        $item->delete();
        
        // Atur ulang sort_order setelah item dihapus
        $this->reorderAllItems();

        return redirect()->route('admin.dashboard')->with('error', 'Item carousel berhasil dihapus.');
    }
    
    /**
     * Mengatur ulang urutan item.
     */
    private function reorderItems(HomeCarouselItem $updatedItem, int $newOrder)
    {
        // Pindahkan semua item lain untuk memberi ruang
        HomeCarouselItem::where('id', '!=', $updatedItem->id)
            ->where('sort_order', '>=', $newOrder)
            ->increment('sort_order');
        
        // Pastikan tidak ada duplikasi sort_order
        $this->reorderAllItems();
    }
    
    private function reorderAllItems()
    {
        $items = HomeCarouselItem::orderBy('sort_order')->get();
        foreach ($items as $index => $item) {
            $item->sort_order = $index + 1;
            $item->save();
        }
    }
}