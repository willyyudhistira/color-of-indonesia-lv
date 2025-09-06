<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;

class TestimonialService
{
    /**
     * Mengambil semua testimonial yang dipublikasikan, diurutkan.
     */
    public function getPublishedTestimonials(): Collection
    {
        return Testimonial::where('is_published', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Membuat testimonial baru.
     */
    public function createTestimonial(array $data): Testimonial
    {
        return Testimonial::create($data);
    }

    /**
     * Memperbarui data testimonial.
     */
    public function updateTestimonial(Testimonial $testimonial, array $data): bool
    {
        return $testimonial->update($data);
    }

    /**
     * Menghapus testimonial.
     */
    public function deleteTestimonial(Testimonial $testimonial): bool
    {
        return $testimonial->delete();
    }
}