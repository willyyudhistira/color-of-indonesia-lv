<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\HomeCarouselItem; // Import model

class StoreCarouselItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Aturan validasi kustom untuk membatasi jumlah item
        $maxItems = 4;
        $currentItemCount = HomeCarouselItem::count();

        return [
            'image_url' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:5120',
                function ($attribute, $value, $fail) use ($maxItems, $currentItemCount) {
                    if ($currentItemCount >= $maxItems) {
                        $fail("Upload gagal. Jumlah item carousel sudah mencapai batas maksimal ({$maxItems}).");
                    }
                },
            ],
            'alt_text' => 'nullable|string|max:150',
            'link_url' => 'nullable|url|max:255',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => filter_var($this->is_published, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true,
        ]);
    }
}