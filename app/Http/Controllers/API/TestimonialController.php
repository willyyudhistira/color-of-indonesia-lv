<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest; // Gunakan request yang sesuai
use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    // Dependency Injection untuk Service
    public function __construct(private TestimonialService $testimonialService)
    {
    }

    /**
     * Menampilkan daftar testimoni (untuk publik).
     */
    public function index(): JsonResponse
    {
        $testimonials = $this->testimonialService->getPublishedTestimonials();
        return response()->json($testimonials);
    }

    /**
     * Menyimpan testimoni baru (untuk admin).
     */
    public function store(StoreTestimonialRequest $request): JsonResponse
    {
        $testimonial = $this->testimonialService->createTestimonial($request->validated());
        return response()->json($testimonial, Response::HTTP_CREATED);
    }

    /**
     * Menampilkan satu testimoni spesifik.
     */
    public function show(Testimonial $testimonial): JsonResponse
    {
        return response()->json($testimonial);
    }

    /**
     * Memperbarui testimoni (untuk admin).
     */
    public function update(StoreTestimonialRequest $request, Testimonial $testimonial): JsonResponse
    {
        $this->testimonialService->updateTestimonial($testimonial, $request->validated());
        return response()->json($testimonial->fresh());
    }

    /**
     * Menghapus testimoni (untuk admin).
     */
    public function destroy(Testimonial $testimonial): Response
    {
        $this->testimonialService->deleteTestimonial($testimonial);
        return response()->noContent();
    }
}