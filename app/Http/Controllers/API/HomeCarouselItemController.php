<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Models\HomeCarouselItem;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCarouselItemRequest;
use App\Http\Requests\UpdateCarouselItemRequest;

class HomeCarouselItemController extends Controller
{
    /**
     * Inject HomeService melalui constructor agar bisa digunakan di semua method.
     */
    public function __construct(private HomeService $homeService)
    {
    }

    /**
     * Menampilkan semua item carousel (untuk admin).
     * Metode ini disebut saat ada request GET ke /api/home-carousel
     */
    public function index(): JsonResponse
    {
        // Mengambil semua data carousel, diurutkan berdasarkan sort_order
        $items = HomeCarouselItem::orderBy('sort_order', 'asc')->get();
        return response()->json($items);
    }

    /**
     * Menyimpan item carousel baru.
     * Metode ini disebut saat ada request POST ke /api/home-carousel
     */
    public function store(Request $request): JsonResponse // Ganti Request dengan StoreCarouselItemRequest
    {
        // Validasi input (lebih baik dipindahkan ke Form Request)
        $validatedData = $request->validate([
            'image_url' => 'required|image|max:2048', // Wajib gambar, maks 2MB
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
            // Validasi jumlah item maksimal bisa ditambahkan di Form Request
        ]);

        // Panggil service untuk membuat item baru
        $item = $this.homeService->createItem(
            HomeCarouselItem::class,
            $validatedData,
            'image_url',       // Nama field file di database
            'carousel_images'  // Nama folder penyimpanan di storage
        );

        return response()->json($item, Response::HTTP_CREATED); // 201 Created
    }

    /**
     * Menampilkan satu item carousel spesifik.
     * Metode ini disebut saat ada request GET ke /api/home-carousel/{id}
     */
    public function show(HomeCarouselItem $homeCarouselItem): JsonResponse
    {
        // 'HomeCarouselItem $homeCarouselItem' adalah Route Model Binding
        // Laravel otomatis mencari item berdasarkan ID dari URL
        return response()->json($homeCarouselItem);
    }

    /**
     * Memperbarui item carousel yang sudah ada.
     * Metode ini disebut saat ada request PUT/PATCH ke /api/home-carousel/{id}
     */
    public function update(Request $request, HomeCarouselItem $homeCarouselItem): JsonResponse // Ganti Request dengan UpdateCarouselItemRequest
    {
        $validatedData = $request->validate([
            'image_url' => 'nullable|image|max:2048', // Tidak wajib saat update
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);
        
        if ($request->hasFile('image_url')) {
            $validatedData['image_url'] = $request->file('image_url');
        }

        // Panggil service untuk update item
        $item = $this.homeService->updateItem(
            $homeCarouselItem,
            $validatedData,
            'image_url',
            'carousel_images'
        );

        return response()->json($item);
    }

    /**
     * Menghapus item carousel.
     * Metode ini disebut saat ada request DELETE ke /api/home-carousel/{id}
     */
    public function destroy(HomeCarouselItem $homeCarouselItem): Response
    {
        // Panggil service untuk menghapus item (termasuk filenya)
        $this.homeService->deleteItem($homeCarouselItem, 'image_url');

        return response()->noContent(); // 204 No Content
    }
}