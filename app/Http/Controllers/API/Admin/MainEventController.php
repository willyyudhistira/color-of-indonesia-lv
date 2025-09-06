<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainEvent;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainEventController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function show(): JsonResponse
    {
        // Ambil data pertama, atau buat data kosong baru jika tidak ada
        $mainEvent = MainEvent::firstOrNew();
        return response()->json($mainEvent);
    }

    public function update(Request $request): JsonResponse // Ganti Request dengan UpdateMainEventRequest
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'required|string',
            'description' => 'nullable|string',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'hero_image_url' => 'nullable|image|max:4096',
        ]);

        // Gunakan updateOrCreate untuk menangani kasus data belum ada
        $mainEvent = MainEvent::firstOrNew();

        if ($request->hasFile('hero_image_url')) {
            $validatedData['hero_image_url'] = $request->file('hero_image_url');
        }

        $item = $this->homeService->updateItem(
            $mainEvent,
            $validatedData,
            'hero_image_url',
            'main_event_hero'
        );

        return response()->json($item);
    }
}