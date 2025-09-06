<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ganti dengan logic otorisasi, misal: return $this->user()->isAdmin();
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'required|string',
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ];
    }

    /**
     * Siapkan data untuk validasi.
     */
    protected function prepareForValidation(): void
    {
        // Konversi 'true'/'false' string ke boolean dan default value
        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => filter_var($this->is_published, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}