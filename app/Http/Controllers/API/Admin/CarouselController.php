<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarouselItemRequest;
use App\Models\HomeCarouselItem;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarouselController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(HomeCarouselItem::orderBy('sort_order')->get());
    }

    public function store(StoreCarouselItemRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        $item = $this->homeService->createItem(
            HomeCarouselItem::class, 
            $validatedData, 
            'image_url', 
            'carousel_images'
        );

        return response()->json($item, Response::HTTP_CREATED);
    }

    public function update(Request $request, HomeCarouselItem $carousel): JsonResponse
    {
        // Sebaiknya buat UpdateCarouselItemRequest
        $validatedData = $request->validate([
            'image_url' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);
        
        if ($request->hasFile('image_url')) {
            $validatedData['image_url'] = $request->file('image_url');
        }

        $item = $this->homeService->updateItem(
            $carousel, 
            $validatedData, 
            'image_url', 
            'carousel_images'
        );

        return response()->json($item);
    }

    public function destroy(HomeCarouselItem $carousel): Response
    {
        $this->homeService->deleteItem($carousel, 'image_url');
        return response()->noContent();
    }
}