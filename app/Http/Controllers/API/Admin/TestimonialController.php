<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(Testimonial::orderBy('sort_order')->get());
    }

    public function store(Request $request): JsonResponse // Ganti Request dengan StoreTestimonialRequest
    {
        $validatedData = $request->validate([
            'author_name' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'avatar_url' => 'nullable|image|max:2048',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);
        
        if ($request->hasFile('avatar_url')) {
            $validatedData['avatar_url'] = $request->file('avatar_url');
        }

        $item = $this->homeService->createItem(
            Testimonial::class,
            $validatedData,
            'avatar_url',
            'testimonial_avatars'
        );

        return response()->json($item, Response::HTTP_CREATED);
    }

    public function update(Request $request, Testimonial $testimonial): JsonResponse // Ganti Request dengan UpdateTestimonialRequest
    {
        $validatedData = $request->validate([
            'author_name' => 'sometimes|required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'quote' => 'sometimes|required|string',
            'avatar_url' => 'nullable|image|max:2048',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('avatar_url')) {
            $validatedData['avatar_url'] = $request->file('avatar_url');
        }

        $item = $this->homeService->updateItem(
            $testimonial,
            $validatedData,
            'avatar_url',
            'testimonial_avatars'
        );

        return response()->json($item);
    }

    public function destroy(Testimonial $testimonial): Response
    {
        $this->homeService->deleteItem($testimonial, 'avatar_url');
        return response()->noContent();
    }
}