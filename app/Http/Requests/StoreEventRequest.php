<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asumsikan otorisasi ditangani oleh middleware
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'hero_image_url' => 'nullable|image|max:4096', // 4MB max
            'form_url' => 'required|url',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
        ];
    }

    /**
     * Menyiapkan data sebelum divalidasi.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN),
            'is_published' => filter_var($this->is_published, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}