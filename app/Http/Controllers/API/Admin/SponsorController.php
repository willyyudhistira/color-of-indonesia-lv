<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; // Gunakan Request generik untuk update jika tidak ada UpdateSponsorRequest
use Illuminate\Http\Response;
// use App\Http\Requests\StoreSponsorRequest; // Aktifkan jika sudah dibuat
// use App\Http\Requests\UpdateSponsorRequest; // Aktifkan jika sudah dibuat


class SponsorController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(Sponsor::orderBy('sort_order')->get());
    }

    public function store(Request $request): JsonResponse // Ganti Request dengan StoreSponsorRequest
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:120',
            'logo_url' => 'required|image|max:2048',
            'website_url' => 'nullable|url',
            'tier' => 'nullable|string|max:50',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);

        $item = $this->homeService->createItem(
            Sponsor::class,
            $validatedData,
            'logo_url',
            'sponsor_logos'
        );

        return response()->json($item, Response::HTTP_CREATED);
    }

    public function update(Request $request, Sponsor $sponsor): JsonResponse // Ganti Request dengan UpdateSponsorRequest
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:120',
            'logo_url' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url',
            'tier' => 'nullable|string|max:50',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);
        
        if ($request->hasFile('logo_url')) {
            $validatedData['logo_url'] = $request->file('logo_url');
        }

        $item = $this->homeService->updateItem(
            $sponsor,
            $validatedData,
            'logo_url',
            'sponsor_logos'
        );

        return response()->json($item);
    }

    public function destroy(Sponsor $sponsor): Response
    {
        $this->homeService->deleteItem($sponsor, 'logo_url');
        return response()->noContent();
    }
}