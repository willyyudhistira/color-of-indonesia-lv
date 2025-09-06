<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorBanner;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(SponsorBanner::orderBy('sort_order')->get());
    }

    public function store(Request $request): JsonResponse // Ganti Request dengan StoreBannerRequest
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:120',
            'image_url' => 'required|image|max:2048',
            'link_url' => 'nullable|url',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);

        $item = $this->homeService->createItem(
            SponsorBanner::class,
            $validatedData,
            'image_url',
            'sponsor_banners'
        );

        return response()->json($item, Response::HTTP_CREATED);
    }

    public function update(Request $request, SponsorBanner $banner): JsonResponse // Ganti Request dengan UpdateBannerRequest
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:120',
            'image_url' => 'nullable|image|max:2048',
            'link_url' => 'nullable|url',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);
        
        if ($request->hasFile('image_url')) {
            $validatedData['image_url'] = $request->file('image_url');
        }

        $item = $this->homeService->updateItem(
            $banner,
            $validatedData,
            'image_url',
            'sponsor_banners'
        );

        return response()->json($item);
    }

    public function destroy(SponsorBanner $banner): Response
    {
        $this->homeService->deleteItem($banner, 'image_url');
        return response()->noContent();
    }
}